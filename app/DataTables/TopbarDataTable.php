<?php

namespace App\DataTables;

use App\Models\Topbar;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TopbarDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('marquee_preview', function ($t) {
                return '<div class="small fw-semibold text-dark" style="max-width: 250px;"><i class="bi bi-broadcast text-danger me-1"></i>'.e($t->marquee_text ?? '-').'</div>';
            })
            ->addColumn('badge_preview', function ($t) {
                $icon = ! empty($t->badge_icon) ? $t->badge_icon : 'bi-laptop';

                return '<span class="badge rounded-pill text-nowrap" style="background: rgba(249, 220, 75, 0.25); color: #000000; border: 1px solid #f9dc4b; font-weight:700; padding:6px 12px;">
                            <i class="bi '.e($icon).' me-1 text-warning"></i>'.e($t->badge_text).'
                        </span>';
            })
            ->editColumn('alamat', function ($t) {
                $cleanAlamat = trim(html_entity_decode(strip_tags($t->alamat ?? '-'), ENT_QUOTES, 'UTF-8'));

                return '<div class="small text-dark" style="max-width: 250px;"><i class="bi bi-geo-alt me-1 text-warning"></i>'.e($cleanAlamat).'</div>';
            })
            ->editColumn('jam_operasional', function ($t) {
                return '<div class="small text-dark text-nowrap"><i class="bi bi-clock me-1 text-warning"></i>'.e($t->jam_operasional ?? '-').'</div>';
            })
            ->addColumn('kontak_info', function ($t) {
                $html = '<div class="small text-nowrap">';
                if (! empty($t->telepon)) {
                    $html .= '<div><i class="bi bi-whatsapp text-success me-1"></i>'.e($t->telepon).'</div>';
                }
                if (! empty($t->email)) {
                    $html .= '<div><i class="bi bi-envelope text-primary me-1"></i>'.e($t->email).'</div>';
                }
                $html .= '</div>';

                return $html;
            })
            ->addColumn('sosmed_preview', function ($t) {
                $html = '<div class="d-flex flex-wrap align-items-center gap-1">';
                $items = is_array($t->social_media) ? $t->social_media : [];
                if (! empty($items)) {
                    foreach ($items as $item) {
                        $icon = ! empty($item['icon']) ? $item['icon'] : 'bi-globe';
                        $platform = $item['platform'] ?? 'Link';
                        $url = $item['url'] ?? '#';
                        $html .= '<a href="'.e($url).'" target="_blank" class="badge bg-light text-dark border p-1" title="'.e($platform).'"><i class="bi '.e($icon).'"></i></a>';
                    }
                } else {
                    $html .= '<span class="text-muted small">-</span>';
                }
                $html .= '</div>';

                return $html;
            })
            ->addColumn('status', function ($t) {
                return $t->is_active
                    ? '<span class="badge bg-success text-nowrap">Aktif</span>'
                    : '<span class="badge bg-secondary text-nowrap">Nonaktif</span>';
            })
            ->addColumn('action', function ($t) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('topbar.edit', $t->id).'"
                            class="btn btn-sm btn-warning text-dark fw-bold"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('topbar.destroy', $t->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus pengaturan topbar ini?\')">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit"
                                   class="btn btn-sm btn-danger"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                           </button>
                         </form>';

                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['marquee_preview', 'badge_preview', 'alamat', 'jam_operasional', 'kontak_info', 'sosmed_preview', 'status', 'action']);
    }

    public function query(Topbar $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('topbar-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
            ])
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width('50px')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('marquee_preview')->title('Teks Marquee (Berjalan)')->width('260px')->searchable(true),
            Column::make('badge_preview')->title('Badge Topbar')->width('140px')->searchable(true),
            Column::make('kontak_info')->title('Kontak & Email')->width('160px')->searchable(true),
            Column::make('sosmed_preview')->title('Media Sosial')->width('140px')->addClass('text-center'),
            Column::make('status')->title('Status')->width('90px')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('90px')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Topbar_'.date('YmdHis');
    }
}
