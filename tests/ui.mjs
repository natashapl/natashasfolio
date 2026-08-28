/**
 * UI behaviour + accessibility checks.
 *
 * Serves the site locally and drives the browser already installed on this
 * machine (via playwright-core, so no extra browser download).
 *
 *   npm run test:ui
 */

import http from 'node:http';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright-core';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');

const CONTENT_TYPES = {
  '.html': 'text/html',
  '.js': 'text/javascript',
  '.css': 'text/css',
  '.svg': 'image/svg+xml',
  '.webp': 'image/webp',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.ico': 'image/x-icon',
  '.woff2': 'font/woff2',
  '.json': 'application/json',
  '.webmanifest': 'application/manifest+json',
};

function startServer() {
  const server = http.createServer((req, res) => {
    const urlPath = decodeURIComponent(req.url.split('?')[0]);
    const filePath = path.join(root, urlPath === '/' ? 'index.html' : urlPath);

    // Stay inside the repo
    if (!filePath.startsWith(root)) {
      res.writeHead(403).end();
      return;
    }

    fs.readFile(filePath, (err, data) => {
      if (err) {
        res.writeHead(404).end('Not found');
        return;
      }
      res.writeHead(200, {
        'Content-Type': CONTENT_TYPES[path.extname(filePath).toLowerCase()] || 'application/octet-stream',
      });
      res.end(data);
    });
  });

  return new Promise((resolve) => {
    server.listen(0, '127.0.0.1', () => resolve({ server, port: server.address().port }));
  });
}

/* ---------- tiny assertion harness ---------- */

const results = [];

function check(name, passed, detail = '') {
  results.push({ name, passed, detail });
  console.log(`${passed ? '  PASS' : '  FAIL'}  ${name}${detail && !passed ? `\n        ${detail}` : ''}`);
}

function section(title) {
  console.log(`\n${title}`);
}

/* ---------- reviewed exceptions ---------- */

// axe reports "incomplete" when it cannot decide on its own. Anything not
// listed here fails the run, so a new needs-review item can never slip past.
// Each entry must be something a human checked and accepted.
const ACCEPTED_INCOMPLETE = [
  {
    id: 'color-contrast',
    // Decorative curly quote glyphs in the testimonials. axe cannot measure
    // contrast on characters it does not treat as text.
    reason: 'Element content contains only non-text characters',
  },
];

function isAccepted(ruleId, node) {
  const messages = [...(node.any || []), ...(node.all || []), ...(node.none || [])]
    .map((c) => c.message)
    .filter(Boolean);

  return ACCEPTED_INCOMPLETE.some(
    (a) => a.id === ruleId && messages.some((m) => m.includes(a.reason))
  );
}

/* ---------- helpers ---------- */

// The scroll handler is throttled at 100ms, so give it room to settle.
const settle = (page) => page.waitForTimeout(350);

async function hash(page) {
  return page.evaluate(() => window.location.hash);
}

async function run() {
  const { server, port } = await startServer();
  const base = `http://127.0.0.1:${port}`;

  let browser;
  try {
    browser = await chromium.launch({ channel: 'chrome' });
  } catch {
    browser = await chromium.launch({ channel: 'msedge' });
  }

  // reducedMotion makes scrolling instant, so assertions are deterministic
  const context = await browser.newContext({
    viewport: { width: 1280, height: 900 },
    reducedMotion: 'reduce',
  });
  const page = await context.newPage();

  // Keep the run offline: block anything not served by us (analytics, etc.)
  await page.route('**', (route) => {
    route.request().url().startsWith(base) ? route.continue() : route.abort();
  });

  await page.goto(base, { waitUntil: 'load' });
  await settle(page);

  /* ---------- back to top button ---------- */
  section('Back to top button');

  const exists = await page.locator('#back-to-top').count();
  check('button is present in the DOM', exists === 1);

  const hiddenAtTop = await page.evaluate(() =>
    !document.getElementById('back-to-top').classList.contains('isVisible')
  );
  check('hidden while still in the home section', hiddenAtTop);

  // Scroll to just before the end of the home section - still should be hidden
  await page.evaluate(() => {
    const home = document.getElementById('home');
    window.scrollTo(0, home.offsetTop + home.offsetHeight - 50);
  });
  await settle(page);
  const hiddenJustBefore = await page.evaluate(() =>
    !document.getElementById('back-to-top').classList.contains('isVisible')
  );
  check('still hidden just before the home section ends', hiddenJustBefore);

  // Scroll past the home section - should appear
  await page.evaluate(() => {
    const home = document.getElementById('home');
    window.scrollTo(0, home.offsetTop + home.offsetHeight + 50);
  });
  await settle(page);
  const visibleAfter = await page.evaluate(() =>
    document.getElementById('back-to-top').classList.contains('isVisible')
  );
  check('appears once the home section is scrolled past', visibleAfter);

  const clickable = await page.evaluate(() => {
    const el = document.getElementById('back-to-top');
    const style = getComputedStyle(el);
    return style.visibility === 'visible' && Number(style.opacity) > 0.9;
  });
  check('is actually visible to the user (not just class-toggled)', clickable);

  /* ---------- hash behaviour ---------- */
  section('URL hash');

  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  await settle(page);
  const hashAtBottom = await hash(page);
  check('a section hash is set while scrolled down', hashAtBottom !== '', `got "${hashAtBottom}"`);

  await page.click('#back-to-top');
  await settle(page);

  const scrollY = await page.evaluate(() => window.scrollY);
  check('back to top scrolls to the very top', scrollY === 0, `scrollY = ${scrollY}`);

  const hashAtTop = await hash(page);
  check('no hash remains at the top (not #portfolio)', hashAtTop === '', `got "${hashAtTop}"`);

  // Escape with nothing open must not rewrite the hash
  await page.keyboard.press('Escape');
  await settle(page);
  const hashAfterEscape = await hash(page);
  check('Escape with no panel open leaves the hash alone', hashAfterEscape === '', `got "${hashAfterEscape}"`);

  // Nav links keep the section the user asked for
  await page.click('nav a[href="#about"]');
  await settle(page);
  const hashAfterNav = await hash(page);
  check('clicking a nav link keeps that section hash', hashAfterNav === '#about', `got "${hashAfterNav}"`);

  /* ---------- aria-controls integrity ---------- */
  section('ARIA wiring');

  const dangling = await page.evaluate(() =>
    [...document.querySelectorAll('[aria-controls]')]
      .map((el) => el.getAttribute('aria-controls'))
      .filter((id) => !document.getElementById(id))
  );
  check('every aria-controls points at a real element', dangling.length === 0, `dangling: ${JSON.stringify(dangling)}`);

  // Open a project, then another, and confirm only one trigger is expanded
  await page.evaluate(() => window.scrollTo(0, document.getElementById('portfolio').offsetTop));
  await settle(page);

  await page.click('[data-project="personalFinanceDetail"] .gridItemLink');
  await settle(page);

  const afterFirstOpen = await page.evaluate(() =>
    [...document.querySelectorAll('.gridItemLink[aria-expanded="true"]')]
      .map((el) => el.closest('[data-project]')?.getAttribute('data-project'))
  );
  check('opening a project expands exactly that one trigger',
    afterFirstOpen.length === 1 && afterFirstOpen[0] === 'personalFinanceDetail',
    `expanded: ${JSON.stringify(afterFirstOpen)}`);

  const panelOpen = await page.evaluate(() => document.body.classList.contains('show-detail'));
  check('panel is open', panelOpen);

  // Open a second project while the first is still open
  await page.click('[data-project="moodTrackerDetail"] .gridItemLink');
  await settle(page);

  const afterSecondOpen = await page.evaluate(() =>
    [...document.querySelectorAll('.gridItemLink[aria-expanded="true"]')]
      .map((el) => el.closest('[data-project]')?.getAttribute('data-project'))
  );
  check('switching projects leaves only the new trigger expanded',
    afterSecondOpen.length === 1 && afterSecondOpen[0] === 'moodTrackerDetail',
    `expanded: ${JSON.stringify(afterSecondOpen)}`);

  const danglingWhileOpen = await page.evaluate(() =>
    [...document.querySelectorAll('[aria-controls]')]
      .map((el) => el.getAttribute('aria-controls'))
      .filter((id) => !document.getElementById(id))
  );
  check('aria-controls still all resolve while a panel is open',
    danglingWhileOpen.length === 0, `dangling: ${JSON.stringify(danglingWhileOpen)}`);

  // The panel copies markup from the hidden source, so ids must not be cloned
  const dupIds = await page.evaluate(() => {
    const counts = {};
    document.querySelectorAll('[id]').forEach((el) => {
      counts[el.id] = (counts[el.id] || 0) + 1;
    });
    return Object.entries(counts).filter(([, n]) => n > 1);
  });
  check('no duplicate ids in the document while a panel is open',
    dupIds.length === 0, JSON.stringify(dupIds));

  const panelLabel = await page.evaluate(() => {
    const id = document.querySelector('.asideContainer').getAttribute('aria-labelledby');
    const target = document.getElementById(id);
    return { id, found: !!target, insidePanel: !!target && document.querySelector('.asideContainer').contains(target) };
  });
  check('panel is labelled by a heading inside itself',
    panelLabel.found && panelLabel.insidePanel, JSON.stringify(panelLabel));

  /* ---------- close + focus ---------- */
  section('Closing the panel');

  await page.click('.asideContainer .close');
  await settle(page);
  await page.waitForFunction(
    () => getComputedStyle(document.querySelector('.asideContainer')).visibility === 'hidden'
  );

  const closed = await page.evaluate(() => ({
    hasClass: document.body.classList.contains('show-detail'),
    expanded: document.querySelectorAll('.gridItemLink[aria-expanded="true"]').length,
  }));
  check('panel closes', !closed.hasClass);
  check('no trigger is left marked as expanded', closed.expanded === 0, `${closed.expanded} still expanded`);

  /* ---------- axe: every state, every theme, fail on anything ---------- */
  section('axe accessibility scan');

  await page.addScriptTag({ path: path.join(root, 'node_modules/axe-core/axe.min.js') });

  const violations = [];
  const incomplete = [];

  async function setTheme(name) {
    const current = await page.evaluate(() => document.documentElement.getAttribute('data-theme'));
    if (current !== name) {
      await page.click('#theme-toggle');
      await settle(page);
    }
  }

  async function openPanel() {
    await page.click('[data-project="personalFinanceDetail"] .gridItemLink');
    await settle(page);
  }

  async function closePanel() {
    await page.click('.asideContainer .close');
    await settle(page);
    // The hide is transition-delayed, so wait for it rather than guess
    await page.waitForFunction(
      () => getComputedStyle(document.querySelector('.asideContainer')).visibility === 'hidden'
    );
  }

  async function scan(label) {
    const res = await page.evaluate(async () => await window.axe.run(document));
    for (const v of res.violations) violations.push({ label, v });
    for (const i of res.incomplete) incomplete.push({ label, i });

    check(`no violations - ${label}`, res.violations.length === 0,
      res.violations.map((v) => `${v.id} x${v.nodes.length}`).join(', '));

    // Needs-review items count as failures unless explicitly accepted above
    const unreviewed = res.incomplete.flatMap((i) =>
      i.nodes.filter((n) => !isAccepted(i.id, n)).map(() => i.id)
    );
    check(`no unreviewed needs-review items - ${label}`, unreviewed.length === 0,
      [...new Set(unreviewed)].join(', '));
  }

  await setTheme('light');
  await scan('default view, light theme');
  await openPanel();
  await scan('project panel open, light theme');
  await closePanel();

  await setTheme('dark');
  await scan('default view, dark theme');
  await openPanel();
  await scan('project panel open, dark theme');
  await closePanel();
  await setTheme('light');

  if (violations.length) {
    console.log('\n  Violations:');
    const seen = new Set();
    for (const { label, v } of violations) {
      const key = `${v.id}|${label}`;
      if (seen.has(key)) continue;
      seen.add(key);
      console.log(`    ${v.id} (${v.impact}) x${v.nodes.length} - ${label}`);
      console.log(`      ${v.help}`);
      for (const n of v.nodes.slice(0, 3)) console.log(`        ${n.target.join(' ')}`);
    }
  }

  if (incomplete.length) {
    console.log('');
    console.log('  Needs review (axe "incomplete"):');
    const seen = new Set();
    for (const { label, i } of incomplete) {
      const key = `${i.id}|${label}`;
      if (seen.has(key)) continue;
      seen.add(key);
      console.log(`    ${i.id} x${i.nodes.length} - ${label}`);
      for (const n of i.nodes.slice(0, 4)) {
        console.log(`        ${n.target.join(' ')}`);
        const why = (n.any || []).concat(n.none || []).map((a) => a.message).filter(Boolean);
        if (why.length) console.log(`          -> ${why[0]}`);
      }
    }
  }

  /* ---------- summary ---------- */
  const failed = results.filter((r) => !r.passed);
  console.log(`\n${results.length - failed.length}/${results.length} checks passed`);

  await browser.close();
  server.close();

  if (failed.length) {
    console.log('\nFailed:');
    for (const f of failed) console.log(`  - ${f.name}${f.detail ? ` (${f.detail})` : ''}`);
    process.exitCode = 1;
  }
}

run().catch((err) => {
  console.error(err);
  process.exitCode = 1;
});
