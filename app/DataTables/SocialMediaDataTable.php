<?php

namespace App\DataTables;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SocialMediaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<SocialMedia>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('logo', function ($item) {
                if ($item->logo_url) {
                    return '<img src="'.e($item->logo_url).'" alt="'.e($item->nama).'" 
                                 style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; display: inline-block;">';
                }

                $iconClass = $item->icon ?: 'bi-globe';

                return '<div class="d-inline-flex align-items-center justify-content-center border rounded-2 bg-light text-muted" 
                             style="width: 44px; height: 44px; font-size: 22px;">
                            <i class="bi '.e($iconClass).'"></i>
                        </div>';
            })
            ->addColumn('nama', function ($item) {
                $videoBadge = '';
                if ($item->thumbnail_video_url || $item->video_url) {
                    $videoBadge = '<span class="badge bg-warning text-dark ms-1" style="font-size:10px; font-weight:600;"><i class="bi bi-play-circle-fill me-1"></i>Video Aktif</span>';
                }
                $handleText = $item->handle ? '<small class="text-success fw-semibold d-block" style="font-size:11.5px;">@'.e(ltrim($item->handle, '@')).'</small>' : '<small class="text-muted d-block" style="font-size:11px;">Media Sosial Resmi Fakultas Sains & Teknologi</small>';

                return '<div class="text-start">
                            <div class="fw-bold text-dark" style="font-size:14px; letter-spacing:0.3px;">'.e($item->nama).' '.$videoBadge.'</div>
                            '.$handleText.'
                        </div>';
            })
            ->addColumn('url', function ($item) {
                if (empty($item->url)) {
                    return '<span class="text-muted">—</span>';
                }
                $shortUrl = mb_strimwidth($item->url, 0, 36, '...');

                return '<a href="'.e($item->url).'" target="_blank" rel="noopener noreferrer" 
                           class="btn btn-xs d-inline-flex align-items-center text-truncate" 
                           style="font-size:12px; padding: 4px 10px; background-color: #f0f7f2; color: #046B26; border: 1px solid #d4edd9; border-radius: 6px; font-weight:600; max-width:260px;" 
                           title="'.e($item->url).'">
                            <i class="bi bi-box-arrow-up-right me-1 text-success"></i> '.e($shortUrl).'
                        </a>';
            })
            ->addColumn('urutan', function ($item) {
                return '<span class="badge rounded-pill text-white" style="background-color:#6c757d; font-size:12px; font-weight:700; padding:5px 10px;">'.$item->urutan.'</span>';
            })
            ->addColumn('is_active', function ($item) {
                return $item->is_active
                    ? '<span class="badge" style="background-color:#198754; font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:50px;"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>'
                    : '<span class="badge" style="background-color:#dc3545; font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:50px;"><i class="bi bi-x-circle-fill me-1"></i>Nonaktif</span>';
            })
            ->addColumn('kategori', function ($item) {
                if ($item->kategori === 'humas') {
                    return '<span class="badge" style="background-color: #6366f1; color: #ffffff; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 50px;">
                                <i class="bi bi-megaphone-fill me-1"></i>Humas
                            </span>';
                }

                return '<span class="badge" style="background-color: #0284c7; color: #ffffff; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 50px;">
                            <i class="bi bi-buildings me-1"></i>Fakultas Sains & Teknologi
                        </span>';
            })
            ->addColumn('action', function ($item) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:6px">';
                $btn .= '<a href="'.route('social-media.edit', $item->id).'"
                            class="btn btn-sm"
                            style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; background-color:#ff9c00; color:#ffffff; border:none; border-radius:6px; box-shadow:0 2px 5px rgba(255,156,0,0.35);"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';
                $btn .= '<form action="'.route('social-media.destroy', $item->id).'"
                               method="POST" class="m-0"
                               onsubmit="return confirm(\'Yakin ingin menghapus media sosial ini?\')">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit"
                                   class="btn btn-sm"
                                   style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; background-color:#dc3545; color:#ffffff; border:none; border-radius:6px; box-shadow:0 2px 5px rgba(220,53,69,0.35);"
                                   title="Hapus">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                          </button>
                         </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('id')
            ->rawColumns(['logo', 'nama', 'kategori', 'url', 'urutan', 'is_active', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SocialMedia>
     */
    public function query(SocialMedia $model): QueryBuilder
    {
        $query = $model->newQuery();

        if (request()->filled('kategori')) {
            $kat = request('kategori');
            if ($kat === 'universitas') {
                $query->where(function ($q) {
                    $q->where('kategori', 'universitas')->orWhereNull('kategori');
                });
            } else {
                $query->where('kategori', $kat);
            }
        }

        return $query->orderBy('urutan');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('social-media-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5, 'asc')
            ->selectStyleSingle()
            ->parameters([
                'pageLength' => 10,
                'language' => [
                    'search' => 'Search:',
                    'lengthMenu' => '_MENU_ entries per page',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'first' => '«',
                        'last' => '»',
                        'next' => '›',
                        'previous' => '‹',
                    ],
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width('5%')->addClass('text-center align-middle')->searchable(false)->orderable(false),
            Column::computed('logo')->title('Logo PNG')->width('9%')->addClass('text-center align-middle')->exportable(false)->printable(false),
            Column::make('nama')->title('Nama Platform')->addClass('align-middle'),
            Column::computed('kategori')->title('Kategori')->width('12%')->addClass('text-center align-middle'),
            Column::computed('url')->title('Tautan / URL')->width('24%')->addClass('align-middle'),
            Column::make('urutan')->title('Urutan')->width('8%')->addClass('text-center align-middle'),
            Column::make('is_active')->title('Status')->width('10%')->addClass('text-center align-middle'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('10%')->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SocialMedia_'.date('YmdHis');
    }
}
