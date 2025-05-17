@extends('layouts.backend.app')

@section('header', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
  @if(auth()->user()->role_id == 1) {{-- Admin --}}
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{$artikelCount}}</h3>
        <p>Total Artikel</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-albums"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{$approvedArticles ?? 0}}</h3>
        <p>Artikel Disetujui</p>
      </div>
      <div class="icon">
        <i class="ion ion-checkmark-circled"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{$userCount}}</h3>
        <p>Total Pengguna</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{$pendingReviews ?? 0}}</h3>
        <p>Artikel Menunggu Review</p>
      </div>
      <div class="icon">
        <i class="ion ion-clock"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <!-- Grafik untuk Admin -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Statistik Artikel</h3>
      </div>
      <div class="card-body">
        <canvas id="articleStats" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Aktivitas Terbaru</h3>
      </div>
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          <!-- Daftar aktivitas terbaru -->
          <li class="item">
            <div class="product-img">
              <img src="{{ asset('dist/img/default-150x150.png') }}" alt="User Image" class="img-size-50">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Artikel baru ditambahkan
                <span class="badge badge-info float-right">Baru</span></a>
              <span class="product-description">
                "Judul Artikel Terbaru" oleh Author XYZ
              </span>
            </div>
          </li>
          <!-- Tambahkan item aktivitas lainnya di sini -->
        </ul>
      </div>
    </div>
  </div>
  @endif
  
  @if(auth()->user()->role_id == 2) {{-- Reviewer --}}
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{$assignedArticles ?? 0}}</h3>
        <p>Artikel Ditugaskan</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-paper"></i>
      </div>
      <a href="{{ route('reviewer.artikel.index') }}" class="small-box-footer">Lihat Artikel <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{$pendingReviews ?? 0}}</h3>
        <p>Menunggu Review</p>
      </div>
      <div class="icon">
        <i class="ion ion-clock"></i>
      </div>
      <a href="{{ route('reviewer.artikel.index') }}" class="small-box-footer">Review Sekarang <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{$completedReviews ?? 0}}</h3>
        <p>Review Selesai</p>
      </div>
      <div class="icon">
        <i class="ion ion-checkmark-circled"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <!-- Daftar artikel yang perlu direview -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Artikel Yang Perlu Direview</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Tanggal</th>
              <th>Status</th>
              {{-- <th>Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @if(isset($articlesToReview) && count($articlesToReview) > 0)
              @foreach($articlesToReview as $article)
              <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->user->name }}</td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
                <td><span class="badge badge-warning">Menunggu Review</span></td>
                {{-- <td>
                  <a href="{{ route('reviewer.artikel.review-form', $article->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-check-circle"></i> Review
                  </a>
                </td> --}}
              </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5" class="text-center">Tidak ada artikel yang perlu direview saat ini.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif
  
  @if(auth()->user()->role_id == 3) {{-- Author --}}
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{$myArticles ?? 0}}</h3>
        <p>Artikel Saya</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-paper"></i>
      </div>
      <a href="#" class="small-box-footer">Lihat Artikel <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{$publishedArticles ?? 0}}</h3>
        <p>Artikel Dipublikasikan</p>
      </div>
      <div class="icon">
        <i class="ion ion-checkmark-circled"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{$pendingArticles ?? 0}}</h3>
        <p>Menunggu Persetujuan</p>
      </div>
      <div class="icon">
        <i class="ion ion-clock"></i>
      </div>
      <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  
  <!-- Tombol buat artikel baru -->
  <div class="col-md-12 mb-4">
    <a href="{{ route('create.artikel') }}" class="btn btn-primary btn-lg btn-block">
      <i class="fas fa-plus"></i> Buat Artikel Baru
    </a>
  </div>
  
  <!-- Daftar artikel terbaru dari author -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Artikel Terbaru Saya</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($recentArticles) && count($recentArticles) > 0)
              @foreach($recentArticles as $article)
              <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->category->name }}</td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
                <td>
                  @if($article->status == 'approved')
                    <span class="badge badge-success">Dipublikasikan</span>
                  @elseif($article->status == 'pending_review')
                    <span class="badge badge-warning">Menunggu Review</span>
                  @elseif($article->status == 'rejected')
                    <span class="badge badge-danger">Ditolak</span>
                  @else
                    <span class="badge badge-secondary">Draft</span>
                  @endif
                </td>
                <td>
                  <a href="#" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('edit.artikel', $article->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5" class="text-center">Anda belum membuat artikel.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif
</div>
<!-- /.row -->

@if(auth()->user()->role_id == 1)
<!-- Script untuk chart admin -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Chart untuk statistik artikel
    var ctx = document.getElementById('articleStats').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Disetujui', 'Menunggu Review', 'Ditolak'],
        datasets: [{
          data: [{{ $approvedArticles ?? 0 }}, {{ $pendingReviews ?? 0 }}, {{ $rejectedArticles ?? 0 }}],
          backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });
</script>
@endif

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')
@endsection