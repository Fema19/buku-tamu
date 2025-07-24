@extends('admin.layout')

@section('content')
<div class="statistics-container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Header Section -->
    <div class="stats-header">
        <div class="header-left">
            <h1>Statistik Kunjungan</h1>
            <p class="text-muted">Overview kunjungan tamu PTUN Bandung</p>
        </div>
        <div class="header-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari tamu..." onkeyup="searchTable()">
            </div>
            <div class="filter-actions">
                <button class="btn btn-outline" id="dateFilterBtn" data-bs-toggle="modal" data-bs-target="#dateFilterModal">
                    <i class="fas fa-calendar"></i>
                    <span>Filter Tanggal</span>
                </button>
                <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
                <form action="{{ route('export.tamu') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary" id="exportBtn">
                        <i class="fas fa-download"></i>
                        <span>Export</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Date Filter Modal -->
    <div class="modal fade" id="dateFilterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Tanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="dateFilterForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="startDate" name="start_date">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="endDate" name="end_date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="applyDateFilter()">Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="filterForm">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="">Semua Status</option>
                                <option value="selesai">Selesai</option>
                                <option value="proses">Dalam Proses</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="applyFilter()">Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="stats-overview">
        <div class="stats-grid">
            <div class="stats-box total">
                <div class="stats-content">
                    <div class="stats-header">
                        <div class="icon-circle">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div class="trend-badge positive">
                            <i class="fas fa-arrow-up"></i> 12%
                        </div>
                    </div>
                    <div class="stats-body">
                        <h4>Total Pengunjung</h4>
                        <div class="stats-value">{{ number_format($totalTamu) }}</div>
                        <div class="stats-description">Jumlah keseluruhan pengunjung</div>
                    </div>
                </div>
            </div>

            <div class="stats-box today">
                <div class="stats-content">
                    <div class="stats-header">
                        <div class="icon-circle">
                            <i class="fas fa-user-clock fa-lg"></i>
                        </div>
                        <div class="trend-badge positive">
                            <i class="fas fa-arrow-up"></i> 5%
                        </div>
                    </div>
                    <div class="stats-body">
                        <h4>Hari Ini</h4>
                        <div class="stats-value">{{ number_format($tamuHariIni) }}</div>
                        <div class="stats-description">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="stats-box weekly">
                <div class="stats-content">
                    <div class="stats-header">
                        <div class="icon-circle">
                            <i class="fas fa-calendar-week fa-lg"></i>
                        </div>
                        <div class="trend-badge negative">
                            <i class="fas fa-arrow-down"></i> 3%
                        </div>
                    </div>
                    <div class="stats-body">
                        <h4>Minggu Ini</h4>
                        <div class="stats-value">{{ number_format($tamuMingguIni) }}</div>
                        <div class="stats-description">7 hari terakhir</div>
                    </div>
                </div>
            </div>

            <div class="stats-box monthly">
                <div class="stats-content">
                    <div class="stats-header">
                        <div class="icon-circle">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div class="trend-badge positive">
                            <i class="fas fa-arrow-up"></i> 8%
                        </div>
                    </div>
                    <div class="stats-body">
                        <h4>Bulan Ini</h4>
                        <div class="stats-value">{{ number_format($tamuBulanIni) }}</div>
                        <div class="stats-description">{{ \Carbon\Carbon::now()->format('F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visitors Section -->
    <div class="content-section">
        <div class="section-header">
            <h2><i class="fas fa-history"></i> Data Kunjungan Tamu</h2>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="modern-table data-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="th-content">
                                    <span>Nama Tamu</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <span>Keperluan</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    <span>Waktu Kunjungan</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTamu as $tamu)
                        <tr>
                            <td>
                                <div class="visitor-info">
                                    <div class="visitor-avatar" style="background-color: {{ '#' . substr(md5($tamu->nama), 0, 6) }}">
                                        {{ strtoupper(substr($tamu->nama, 0, 1)) }}
                                    </div>
                                    <div class="visitor-details">
                                        <div class="visitor-name">{{ $tamu->nama }}</div>
                                        <div class="visitor-id">ID: #{{ str_pad($tamu->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="purpose-info">
                                    <i class="fas fa-info-circle"></i>
                                    <span>{{ $tamu->keperluan }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="visit-time">
                                    <div class="date">
                                        <i class="far fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($tamu->created_at)->format('d M Y') }}
                                    </div>
                                    <div class="time">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($tamu->created_at)->format('H:i') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status-badge status-complete">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Selesai</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-print" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn-action btn-more" title="Menu Lainnya">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <div class="footer-left">
                    Menampilkan 1-10 dari {{ $totalTamu }} data
                </div>
                <div class="pagination">
                    <button class="btn-page" disabled><i class="fas fa-chevron-left"></i></button>
                    <button class="btn-page active">1</button>
                    <button class="btn-page">2</button>
                    <button class="btn-page">3</button>
                    <span class="pagination-dots">...</span>
                    <button class="btn-page">8</button>
                    <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fungsi pencarian
function searchTable() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let table = document.querySelector('.data-table');
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        let showRow = false;
        let cells = rows[i].getElementsByTagName('td');
        
        for (let j = 0; j < cells.length; j++) {
            let text = cells[j].textContent || cells[j].innerText;
            if (text.toLowerCase().indexOf(input) > -1) {
                showRow = true;
                break;
            }
        }
        
        rows[i].style.display = showRow ? '' : 'none';
    }
}

// Fungsi filter tanggal
function applyDateFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        showAlert('Silakan pilih tanggal mulai dan selesai', 'error');
        return;
    }

    // Kirim request AJAX untuk filter
    fetch(`/admin/statistik/filter-date?start_date=${startDate}&end_date=${endDate}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTable(data.tamu);
                showAlert('Filter tanggal berhasil diterapkan', 'success');
                $('#dateFilterModal').modal('hide');
            } else {
                showAlert('Gagal menerapkan filter', 'error');
            }
        })
        .catch(error => {
            showAlert('Terjadi kesalahan pada server', 'error');
        });
}

// Fungsi filter umum
function applyFilter() {
    const status = document.getElementById('statusFilter').value;

    // Kirim request AJAX untuk filter
    fetch(`/admin/statistik/filter?status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTable(data.tamu);
                showAlert('Filter berhasil diterapkan', 'success');
                $('#filterModal').modal('hide');
            } else {
                showAlert('Gagal menerapkan filter', 'error');
            }
        })
        .catch(error => {
            showAlert('Terjadi kesalahan pada server', 'error');
        });
}

// Fungsi untuk update tabel
function updateTable(data) {
    let tbody = document.querySelector('.data-table tbody');
    tbody.innerHTML = '';

    data.forEach(tamu => {
        let row = `
            <tr>
                <td>
                    <div class="visitor-info">
                        <div class="visitor-avatar" style="background-color: #${substr(md5(tamu.nama), 0, 6)}">
                            ${tamu.nama.charAt(0).toUpperCase()}
                        </div>
                        <div class="visitor-details">
                            <div class="visitor-name">${tamu.nama}</div>
                            <div class="visitor-id">ID: #${String(tamu.id).padStart(5, '0')}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="purpose-info">
                        <i class="fas fa-info-circle"></i>
                        <span>${tamu.keperluan}</span>
                    </div>
                </td>
                <td>
                    <div class="visit-time">
                        <div class="date">
                            <i class="far fa-calendar"></i>
                            ${new Date(tamu.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}
                        </div>
                        <div class="time">
                            <i class="far fa-clock"></i>
                            ${new Date(tamu.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="status-badge status-complete">
                        <i class="fas fa-check-circle"></i>
                        <span>Selesai</span>
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action btn-view" title="Lihat Detail" onclick="viewDetail(${tamu.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action btn-print" title="Cetak" onclick="printDetail(${tamu.id})">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn-action btn-more" title="Menu Lainnya">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Fungsi untuk menampilkan alert
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const container = document.querySelector('.statistics-container');
    container.insertBefore(alertDiv, container.firstChild);

    // Auto hide after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Fungsi untuk melihat detail
function viewDetail(id) {
    // Implementasi view detail
    window.location.href = `/admin/tamu/${id}`;
}

// Fungsi untuk print
function printDetail(id) {
    // Implementasi print
    window.open(`/admin/tamu/${id}/print`, '_blank');
}

// Event listener untuk export
document.getElementById('exportBtn').addEventListener('click', function(e) {
    e.preventDefault();
    showAlert('Memulai proses export...', 'info');
    this.form.submit();
});
</script>
@endpush
@endsection
