document.addEventListener('DOMContentLoaded', () => {
  const networkDevicePDF = document.getElementById('perangkatPDF');

  networkDevicePDF.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/perangkat-jaringan/pdf';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const networkItemPDF = document.getElementById('inventarisPDF');

  networkItemPDF.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/inventaris/pdf';
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
    dashboard.classList.add('d-none'); // Sembunyikan dashboard
    formTambah.classList.remove('d-none'); // Tampilkan form

    // Scroll smooth ke form
    formTambah.scrollIntoView({ behavior: 'smooth' });
  });

  kembaliButton.addEventListener('click', function (e) {
    e.preventDefault(); // Supaya tombol tidak submit form
    formTambah.classList.add('d-none'); // Sembunyikan form
    dashboard.classList.remove('d-none'); // Tampilkan dashboard

    // Scroll smooth ke dashboard
    dashboard.scrollIntoView({ behavior: 'smooth' });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const deleteBtn = document.querySelectorAll('[data-bs-target="#deleteDevice"]');
  const confirmBtn = document.getElementById('confirm');
  let selectedId = null;

  deleteBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
    });
  });

  confirmBtn.addEventListener('click', () => {
    window.location.href = '/admin/dashboard/inventaris/hapus/' + selectedId;
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
  const editBtn = document.querySelectorAll('#editDevice');
  let selectedId = null;

  editBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      selectedId = btn.dataset.id;
      window.location.href = '/admin/dashboard/inventaris/edit/' + selectedId;
    });
  });
});

// document.addEventListener('DOMContentLoaded', () => {
//   const selectType = document.getElementById('pilihJenisPerangkat');
//   const deviceName = document.getElementById('namaPerangkat');
//   const devicePassword = document.getElementById('passwordPerangkat');

//   function toggleDisable() {
//     const selectedValue = selectType.value;

//     if (selectedValue === '3') {
//       deviceName.disabled = false;
//       devicePassword.disabled = false;
//     } else {
//       deviceName.disabled = true;
//       devicePassword.disabled = true;
//     }
//   }
//   toggleDisable();
//   selectType.addEventListener('change', toggleDisable);
// });

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
})

const map = L.map('map', {
  center: [-3.445584, 114.84090],
  zoom: 20,
  zoomControl: false,
  dragging: false,
  scrollWheelZoom: false,
  doubleClickZoom: false,
  touchZoom: false,
  boxZoom: false,
  keyboard: false,
});

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

const redIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

const greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

const blueIcon = new L.Icon.Default();

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

      let popupContent = `<b style="text-transform: capitalize;">${device.jenis_nama}</b><br><img src="/uploads/${device.gambar}" style="width:100px; height:auto; margin:5px 0;" alt="${device.nama}"><br>${device.tempat}<br>Lantai ${device.lantai}`;

      if (device.jenis_id.toLowerCase() === '3') {
        popupContent = `<b style="text-transform: capitalize;">${device.SSID} (AP)</b><br><img src="/uploads/${device.gambar}" style="width:100px; height:auto; margin:5px 0;" alt="${device.nama}"><br>${device.tempat}<br>Lantai ${device.lantai}`;
      }

      L.marker([device.latitude, device.longitude], { icon })
        .addTo(map)
        .bindPopup(popupContent);
    });
  })
  .catch(error => console.error('Error fetching devices:', error));