if (window.history.replaceState) {
  const url = new URL(window.location.href);
  if (url.searchParams.has('keyword')) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }
}
document.addEventListener('DOMContentLoaded', () => {
  const networkDevicePDF = document.getElementById('perangkatPDF');

  networkDevicePDF.addEventListener('click', () => {
    window.open('/admin/dashboard/perangkat-jaringan/pdf', '_blank');
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const networkItemPDF = document.getElementById('inventarisPDF');

  networkItemPDF.addEventListener('click', () => {
    window.open('/admin/dashboard/inventaris/pdf', '_blank');
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const networkDeviceBtn = document.getElementById('networkDevice');

  networkDeviceBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/perangkat-jaringan';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const networkDeviceBtn = document.getElementById('networkDevices');

  networkDeviceBtn.addEventListener('click', () => {
    window.location.href = '/perangkat-jaringan';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const placeBtn = document.getElementById('tempat');

  placeBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/tempat';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const itemBtn = document.getElementById('item');

  itemBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/inventaris/';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const itemBtn = document.getElementById('items');

  itemBtn.addEventListener('click', () => {
    window.location.href = '/inventaris/';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const typeBtn = document.getElementById('jenisPerangkat');

  typeBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/jenis-perangkat/';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const invenBtn = document.getElementById('tambahInventaris');

  invenBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/inventaris/import';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const flashMessage = document.querySelectorAll('.flash-message');
  flashMessage.forEach((message) => {
    message.classList.add('show');
  })
  setTimeout(() => {
    flashMessage.forEach((message) => {
      message.classList.add('hide');
      setTimeout(() => {
        message.style.display = 'none'
      }, 500);
    })
  }, 5000);
});

document.addEventListener('DOMContentLoaded', function () {
  const tambahButton = document.getElementById('tambahJenis');
  const kembaliButton = document.getElementById('kembali');
  const dashboard = document.getElementById('dashboard');
  const formTambah = document.getElementById('formTambah');

  tambahButton.addEventListener('click', function () {
    dashboard.classList.add('d-none');
    formTambah.classList.remove('d-none');

    formTambah.scrollIntoView({ behavior: 'smooth' });
  });

  kembaliButton.addEventListener('click', function (e) {
    e.preventDefault();
    formTambah.classList.add('d-none');
    dashboard.classList.remove('d-none');

    dashboard.scrollIntoView({ behavior: 'smooth' });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const tambahTempatButton = document.getElementById('tambahTempat');
  const kembaliButton = document.getElementById('kembali');
  const dashboard = document.getElementById('dashboard');
  const formTambah = document.getElementById('formTambah');

  tambahTempatButton.addEventListener('click', function () {
    dashboard.classList.add('d-none');
    formTambah.classList.remove('d-none');

    formTambah.scrollIntoView({ behavior: 'smooth' });
  });

  kembaliButton.addEventListener('click', function (e) {
    e.preventDefault();
    formTambah.classList.add('d-none');
    dashboard.classList.remove('d-none');

    dashboard.scrollIntoView({ behavior: 'smooth' });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const deleteDevBtn = document.querySelectorAll('[data-bs-target="#deleteDevice"]');
  const confirmDevBtn = document.getElementById('confirm');
  let selectedId = null;

  deleteDevBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
    });
  });

  confirmDevBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/inventaris/hapus/' + selectedId;
  })
});

document.addEventListener('DOMContentLoaded', () => {
  const gambarPetaElements = document.querySelectorAll('.gambarPeta');

  gambarPetaElements.forEach((imgEl) => {
    const tempat = imgEl.closest('.modal-body').dataset.tempat;
    let src = '';

    switch (tempat) {
      case 'Command Center':
        src = '/assets/lantai 1/Lantai 1 - CC.png';
        break;
      case 'Prodi Teknik Pertambangan':
        src = '/assets/lantai 1/Lantai 1 - Prodi Teknik Pertambangan.png';
        break;
      case 'Ruang Kesehatan':
        src = '/assets/lantai 1/Lantai 1 - Ruang Kesehatan.png';
        break;
      case 'Ruang Baca':
        src = '/assets/lantai 1/Lantai 1 - Ruang Baca.png';
        break;
      case 'Prodi Teknik Sipil':
        src = '/assets/lantai 1/Lantai 1 - Prodi Teknik Sipil.png';
        break;
      case 'Lab. Terpadu Teknik Kimia':
        src = '/assets/lantai 1/Lantai 1 - Lab Terpadu Teknik Kimia.png';
        break;
      case 'Prodi Teknik Mesin':
        src = '/assets/lantai 1/Lantai 1 - Prodi Teknik Mesin.png';
        break;
      case 'Prodi Teknik Lingkungan':
        src = '/assets/lantai 1/Lantai 1 - Prodi Teknik Lingkungan.png';
        break;
      case 'Prodi Magister Teknik Kimia':
        src = '/assets/lantai 1/Lantai 1 - Prodi Magister Teknik Kimia.png';
        break;
      case 'Lab. Teknik Mesin':
        src = '/assets/lantai 1/Lantai 1 - Lab Teknik Mesin.png';
        break;
      case 'Lab. Teknik Pertambangan':
        src = '/assets/lantai 1/Lantai 1 - Lab Teknik Pertambangan.png';
        break;
      case 'Lab. Manajemen Lingkungan':
        src = '/assets/lantai 1/Lantai 1 - Lab Manajemen Lingkungan.png';
        break;
      case 'Lab. Proses Teknik Kimia':
        src = '/assets/lantai 1/Lantai 1 - Lab Proses Teknik Kimia.png';
        break;
      case 'Prodi Arsitektur':
        src = '/assets/lantai 2/Lantai 2  Prodi Arsitektur.png';
        break;
      case 'Ruang Layanan Administrasi':
        src = '/assets/lantai 2/Lantai 2 Ruang Layanan Administrasi.png';
        break;
      case 'Ruang Dekan - Wakil Dekan':
        src = '/assets/lantai 2/Lantai 2 Ruang Dekan - Wakil Dekan.png';
        break;
      case 'Ruang Rapat':
        src = '/assets/lantai 2/Lantai 2 Ruang Rapat.png';
        break;
      case 'Ruang ULAT':
        src = '/assets/lantai 2/Lantai 2 Ruang ULAT.png';
        break;
      case 'Prodi Elektro':
        src = '/assets/lantai 2/Lantai 2 Prodi Elektro.png';
        break;
      case 'Prodi Geologi':
        src = '/assets/lantai 2/Lantai 2 Prodi Geologi.png';
        break;
      case 'Ruang Aula II':
        src = '/assets/lantai 2/Lantai 2 Ruang Aula II.png';
        break;
      case 'Prodi Teknik Kimia':
        src = '/assets/lantai 2/Lantai 2 Prodi Teknik Kimia.png';
        break;
      case 'Lab. Teknik Mesin':
        src = '/assets/lantai 2/Lantai 2 Lab Teknik Mesin.png';
        break;
      case 'Lab. Teknik Pertambangan':
        src = '/assets/lantai 2/Lantai 2 Lab Teknik Pertambangan';
        break;
      case 'Ruang Lab. Studio':
        src = '/assets/lantai 2/Lantai 2 Ruang Lab Studio';
        break;
    }

    imgEl.src = src;
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const deleteJenisBtn = document.querySelectorAll('[data-bs-target="#hapusJenis"]');
  const confirmBtn = document.getElementById('confirmJenis');
  let selectedId = null;

  deleteJenisBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
    });
  });

  confirmBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/jenis-perangkat/hapus/' + selectedId;
  })
});

document.addEventListener('DOMContentLoaded', () => {
  const deleteBtn = document.querySelectorAll('[data-bs-target="#hapusTempat"]');
  const confirmBtn = document.getElementById('confirmTempat');
  let selectedId = null;

  deleteBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
    });
  });

  confirmBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/tempat/hapus/' + selectedId;
  })
});

document.addEventListener('DOMContentLoaded', () => {
  const editBtn = document.querySelectorAll('#edit');
  let selectedId = null;

  editBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/item/update/' + selectedId;
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const editJenisBtn = document.querySelectorAll('#editJenis');
  let selectedId = null;

  editJenisBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/jenis-perangkat/edit/' + selectedId;
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const editJenisBtn = document.querySelectorAll('#editTempat');
  let selectedId = null;

  editJenisBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/tempat/edit/' + selectedId;
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const editBtn = document.querySelectorAll('#editDevice');
  let selectedId = null;

  editBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/inventaris/edit/' + selectedId;
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const editTempatBtn = document.querySelectorAll('#editTempat');
  let selectedId = null;

  editTempatBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/tempat/edit/' + selectedId;
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const kondisiSelect = document.getElementById('kondisi');
  const kananDiv = document.getElementById('kanan');
  const kiriDiv = document.getElementById('kiri');

  function toggleKanan() {
    const selectedOption = kondisiSelect.options[kondisiSelect.selectedIndex];
    const selectedText = selectedOption.text.toLowerCase();

    if (selectedText.includes('tidak terpasang')) {
      kananDiv.style.display = 'none';
      kiriDiv.classList.remove('col-md-6');
      kiriDiv.classList.add('col-md-12');
    } else {
      kananDiv.style.display = 'block';
      kiriDiv.classList.remove('col-md-12');
      kiriDiv.classList.add('col-md-6');
    }
  }

  toggleKanan();
  kondisiSelect.addEventListener('change', toggleKanan);
});

document.addEventListener("DOMContentLoaded", function () {
  const activeButton = document.querySelector(".btn-main-active");

  if (activeButton) {
    const icon = activeButton.querySelector("i");
    if (icon) {
      icon.style.color = '#00325C';
    }
    activeButton.classList.add("text-white");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const hoverButton = document.querySelector(".btn-main");
  const icon = activeButton.querySelector("i");

  hoverButton.addEventListener("mouseenter", function () {
    if (icon) {
      icon.style.color = '#002B50';
    }
    hoverButton.classList.add("text-white");
  });

  hoverButton.addEventListener("mouseleave", function () {
    if (icon) {
      icon.style.color = '#00325C';
    }
    hoverButton.classList.add("text-white");
  });
});


const map = L.map('map', {
  center: [-3.445584, 114.84090],
  zoom: 21,
  scrollWheelZoom: false
});

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Ukuran kecil
const iconSize = [16, 26];
const iconAnchor = [8, 26];
const shadowSize = [30, 30];

const redIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize,
  iconAnchor,
  popupAnchor: [1, -20],
  shadowSize
});

const greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize,
  iconAnchor,
  popupAnchor: [1, -20],
  shadowSize
});

const blueIcon = new L.Icon({
  iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
  shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
  iconSize,
  iconAnchor,
  popupAnchor: [1, -20],
  shadowSize
});

fetch('/devices')
  .then(response => response.json())
  .then(data => {
    data.forEach(device => {
      let icon;
      if (device.lantai === '2') {
        icon = redIcon;
      } else if (device.lantai === '3') {
        icon = greenIcon;
      } else {
        icon = blueIcon;
      }

      let popupContent = `<b style="text-transform: capitalize;">${device.jenis_nama}</b>
      <br><img src="/uploads/${device.gambar}" style="width:100px; height:auto; margin:5px 0;" alt="${device.nama}">
      <br><button type="button" class="reset text-decoration-underline" data-bs-toggle="modal" data-bs-target="#${device.id}">
          ${device.tempat}
        </button>
      <br>Lantai ${device.lantai}`;

      if (device.jenis_id.toLowerCase() === '3') {
        popupContent = `<b style="text-transform: capitalize;">${device.SSID} (AP)</b>
        <br><img src="/uploads/${device.gambar}" style="width:100px; height:auto; margin:5px 0;" alt="${device.nama}">
        <br><button type="button" class="reset text-decoration-underline" data-bs-toggle="modal" data-bs-target="#${device.id}">
            ${device.tempat}
          </button>
        <br>Lantai ${device.lantai}`;
      }

      L.marker([device.latitude, device.longitude], { icon })
        .addTo(map)
        .bindPopup(popupContent);
    });
  })
  .catch(error => console.error('Error fetching devices:', error));
