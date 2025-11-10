/**********************
 *  Navbar / Roles
 **********************/
function currentRole() {
  return document.getElementById('roleBadge')?.textContent?.trim() || 'Invitado';
}

function setRole(role) {
  const badge = document.getElementById('roleBadge');
  if (badge) {
    badge.classList.remove('bg-info','bg-primary','bg-secondary');
    badge.classList.add(role === 'Admin' ? 'bg-primary' : (role === 'Analista' ? 'bg-secondary' : 'bg-info'));
    badge.textContent = role;
  }
  // Controles solo para Analista/Admin
  document.querySelectorAll('.role-analyst').forEach(el => {
    const disabled = (role === 'Invitado');
    el.disabled = disabled;
    el.classList.toggle('disabled', disabled);
  });
}

function initNavbar(/* page */) {
  document.querySelectorAll('.role-select').forEach(a => {
    a.addEventListener('click', (e) => {
      e.preventDefault();
      setRole(a.dataset.role);
    });
  });
  setRole(currentRole());
}

/**********************
 *  Dashboard
 **********************/
async function initDashboard(apiSalesUrl) {
  // Línea
  const ctx1 = document.getElementById('chartLine');
  if (ctx1 && typeof Chart !== 'undefined') new Chart(ctx1, {
    type: 'line',
    data: {
      labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
      datasets: [{ label: 'Ventas', data: [92,98,105,110,120,130,128,140,150,158,165,170] }]
    },
    options: { responsive: true }
  });

  // Barras
  const ctx2 = document.getElementById('chartBar');
  if (ctx2 && typeof Chart !== 'undefined') new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Bebidas','Lácteos','Abarrotes','Limpieza'],
      datasets: [{ label: 'Ventas', data: [320,240,380,150] }]
    },
    options: { responsive: true }
  });

  // Tabla de ventas
  try {
    const res = await fetch(apiSalesUrl);
    const rows = await res.json();
    const tbody = document.querySelector('#tblVentas tbody');
    if (tbody) {
      tbody.innerHTML = rows.map(r => `<tr>
        <td>${r[0]}</td><td>${r[1]}</td><td>${r[2]}</td>
        <td>${r[3]}</td><td>${r[4]}</td><td>$${Number(r[5]).toFixed(2)}</td>
      </tr>`).join('');
      if (window.$ && $.fn.DataTable) $('#tblVentas').DataTable();
    }
  } catch (e) {
    console.error('Error cargando ventas:', e);
  }

  document.getElementById('btnApplyFilters')?.addEventListener('click', () => {
    alert('Filtros aplicados (demo).');
  });
}

/**********************
 *  ETL (demo)
 **********************/
async function initETL(apiLogsUrl) {
  await initLogsTable(apiLogsUrl);
}

function etlRun(proceso) {
  const role = currentRole();
  if (role === 'Invitado') {
    alert('Solo Analista/Admin pueden ejecutar procesos.');
    return;
  }

  const status = document.getElementById('etlStatus');
  const bar = document.getElementById('etlProgress');

  if (status) status.textContent = `Ejecutando ${proceso}...`;
  bar?.classList.remove('d-none');

  // Simulación de ejecución
  setTimeout(() => {
    bar?.classList.add('d-none');
    const ok = Math.random() > 0.2; // 80% éxito
    if (status) status.textContent = ok ? `${proceso} finalizado OK.` : `${proceso} finalizado con ERROR.`;

    appendLog({
      fecha: new Date().toISOString().slice(0,16).replace('T',' '),
      proceso,
      estado: ok ? 'OK' : 'ERROR',
      detalle: ok ? 'Ejecución simulada en UI.' : 'ERROR simulado: ORA-00001'
    });
  }, 1200);
}

/**********************
 *  Logs (tabla)
 **********************/
async function initLogsTable(apiLogsUrl) {
  try {
    const res = await fetch(apiLogsUrl);
    const rows = await res.json();
    const tbody = document.querySelector('#tblLogs tbody');
    if (!tbody) return;

    tbody.innerHTML = rows.map(r => rowLogHTML({
      fecha: r[0], proceso: r[1], estado: r[2], detalle: r[3]
    })).join('');

    if (window.$ && $.fn.DataTable) $('#tblLogs').DataTable();
  } catch (e) {
    console.error('Error cargando logs:', e);
  }
}

function rowLogHTML(log) {
  const badge = log.estado === 'OK' ? 'success' : (log.estado === 'WARN' ? 'warning' : 'danger');
  return `<tr>
    <td>${log.fecha}</td>
    <td>${log.proceso}</td>
    <td><span class="badge text-bg-${badge}">${log.estado}</span></td>
    <td>${log.detalle || ''}</td>
  </tr>`;
}

function appendLog(log) {
  if (window.$ && $.fn.DataTable && $('#tblLogs').length) {
    const table = $('#tblLogs').DataTable();
    table.row.add([
      log.fecha,
      log.proceso,
      `<span class="badge text-bg-${log.estado === 'OK' ? 'success' : (log.estado === 'WARN' ? 'warning' : 'danger')}">${log.estado}</span>`,
      log.detalle || ''
    ]).draw(false);
  } else {
    // Fallback si no está DataTables
    const tbody = document.querySelector('#tblLogs tbody');
    if (tbody) tbody.insertAdjacentHTML('beforeend', rowLogHTML(log));
  }
}

/**********************
 *  Uploads (demo)
 *  - Lectura/validación en navegador: CSV, JSON, XLSX (SheetJS)
 **********************/
async function handleUpload(ev) {
  ev.preventDefault();

  const role = currentRole();
  if (role === 'Invitado') {
    alert('Solo Analista/Admin pueden cargar archivos.');
    return false;
  }

  const input  = document.getElementById('fileInput');
  const target = document.getElementById('uploadTarget')?.value || 'STG_PRODUCTO';
  const out    = document.getElementById('uploadResult');

  if (!input?.files?.length) {
    if (out) out.textContent = 'Seleccione un archivo.';
    return false;
  }

  const file = input.files[0];
  const name = file.name;
  const ext  = (name.split('.').pop() || '').toLowerCase();

  if (!['csv','json','xlsx'].includes(ext)) {
    if (out) out.textContent = 'Formato no permitido. Use CSV, JSON o XLSX.';
    return false;
  }

  try {
    const parsed  = await readFileAndParse(file, ext);
    const summary = buildSummary(parsed, ext);

    if (out) {
      out.textContent =
        `Archivo: ${name}\nDestino: ${target}\n` +
        `Registros detectados: ${summary.rows}\n` +
        (summary.headers ? `Encabezados: ${summary.headers.join(', ')}\n` : '') +
        `Estado: VALIDADO ✅ (demo)\n\n` +
        `Muestra:\n${summary.sample}`;
    }

    appendUploadLog(name, target, 'OK');
  } catch (e) {
    console.error(e);
    if (out) out.textContent = `Error de lectura/validación: ${e.message || e}`;
    appendUploadLog(name, target, 'ERROR');
  }

  return false;
}

function appendUploadLog(fileName, target, status) {
  const tbody = document.getElementById('tblUploads');
  if (!tbody) return;
  const now = new Date().toISOString().slice(0,16).replace('T',' ');
  const badge = status === 'OK' ? 'success' : (status === 'WARN' ? 'warning' : 'danger');
  tbody.insertAdjacentHTML('afterbegin', `
    <tr>
      <td>${now}</td>
      <td>${fileName}</td>
      <td>${target}</td>
      <td><span class="badge bg-${badge}">${status}</span></td>
    </tr>
  `);
}

// Lector genérico según extensión
function readFileAndParse(file, ext) {
  return new Promise((resolve, reject) => {
    const fr = new FileReader();

    if (ext === 'json' || ext === 'csv') {
      fr.onload = () => {
        const text = fr.result;
        if (ext === 'json') {
          try { resolve(JSON.parse(text)); } catch (e) { reject(e); }
        } else { // csv
          resolve(parseCSV(text));
        }
      };
      fr.onerror = reject;
      fr.readAsText(file);
    } else if (ext === 'xlsx') {
      fr.onload = () => {
        try {
          if (typeof XLSX === 'undefined') throw new Error('SheetJS no cargado');
          const data = new Uint8Array(fr.result);
          const wb = XLSX.read(data, { type: 'array' });
          const wsName = wb.SheetNames[0];
          const ws = wb.Sheets[wsName];
          const json = XLSX.utils.sheet_to_json(ws, { defval: null });
          resolve(json);
        } catch (e) { reject(e); }
      };
      fr.onerror = reject;
      fr.readAsArrayBuffer(file);
    } else {
      reject(new Error('Extensión no soportada'));
    }
  });
}

// Parser CSV simple (maneja comillas)
function parseCSV(text) {
  const lines = text.split(/\r?\n/).filter(l => l.trim().length);
  if (!lines.length) return [];
  const headers = splitCSVLine(lines[0]);
  return lines.slice(1).map(line => {
    const cols = splitCSVLine(line);
    const obj = {};
    headers.forEach((h, i) => obj[h] = (cols[i] ?? null));
    return obj;
  });
}

function splitCSVLine(line) {
  const out = [];
  let cur = '', quoted = false;
  for (let i = 0; i < line.length; i++) {
    const ch = line[i];
    if (ch === '"') {
      if (quoted && line[i+1] === '"') { cur += '"'; i++; }
      else { quoted = !quoted; }
    } else if (ch === ',' && !quoted) {
      out.push(cur); cur = '';
    } else {
      cur += ch;
    }
  }
  out.push(cur);
  return out.map(s => s.trim());
}

function buildSummary(parsed /*, ext */) {
  let rows = 0, headers = null, sample = '';
  if (Array.isArray(parsed)) {
    rows = parsed.length;
    headers = rows ? Object.keys(parsed[0] || {}) : null;
    sample = JSON.stringify(parsed.slice(0, 5), null, 2);
  } else if (typeof parsed === 'object' && parsed) {
    rows = Array.isArray(parsed.data) ? parsed.data.length : 1;
    sample = JSON.stringify(parsed, null, 2);
  } else {
    sample = String(parsed ?? '');
  }
  return { rows, headers, sample };
}

/**********************
 *  Exponer helpers para Blade
 **********************/
window.initNavbar   = initNavbar;
window.initDashboard= initDashboard;
window.initETL      = initETL;
window.etlRun       = etlRun;
window.handleUpload = handleUpload;
