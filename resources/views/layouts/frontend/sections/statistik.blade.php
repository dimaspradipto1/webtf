@if(isset($homepageStats) && $homepageStats->isNotEmpty())
<style>
  .home-stats-band {
    background: #ffffff;
    padding: 28px 0 18px;
    position: relative;
    z-index: 4;
  }
  .home-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 16px;
  }
  @media (min-width: 992px) {
    .home-stats-grid.cols-5 {
      grid-template-columns: repeat(5, minmax(0, 1fr));
    }
    .home-stats-grid.cols-4 {
      grid-template-columns: repeat(4, minmax(0, 1fr));
    }
  }
  .home-stat-card {
    background: #fefce8;
    border: 1px solid #f3e8c0;
    border-radius: 16px;
    padding: 20px 16px;
    text-align: center;
    transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 108px;
  }
  .home-stat-card:hover {
    transform: translateY(-3px);
    border-color: #f9dc4b;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
  }
  .home-stat-value {
    font-size: clamp(1.35rem, 2.2vw, 1.85rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
  }
  .home-stat-label {
    font-size: 0.84rem;
    font-weight: 600;
    color: #64748b;
    line-height: 1.3;
  }
  @media (max-width: 575.98px) {
    .home-stats-band {
      padding: 20px 0 12px;
    }
    .home-stats-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 10px;
    }
    .home-stat-card {
      padding: 15px 10px;
      min-height: 92px;
    }
  }
</style>

<section id="statistik-beranda" class="home-stats-band" aria-label="Angka Statistik Program Studi">
  <div class="container">
    @php
      $statCount = $homepageStats->count();
      $gridColsClass = $statCount === 5 ? 'cols-5' : ($statCount === 4 ? 'cols-4' : '');
    @endphp
    <div class="home-stats-grid {{ $gridColsClass }}">
      @foreach($homepageStats as $stat)
        <div class="home-stat-card">
          <div class="home-stat-value">{{ $stat->nilai }}</div>
          <div class="home-stat-label">{{ $stat->label }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
