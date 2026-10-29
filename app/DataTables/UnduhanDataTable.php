<?php

namespace App\DataTables;

use App\Models\Unduhan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UnduhanDataTable extends DataTable
{
    /**
     * @param  QueryBuilder<Unduhan>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('judul', fn ($u) => '<span class="fw-semibold text-dark">'.e($u->judul).'</span>')
            ->addColumn('kategori', function ($u) {
                $kat = strtolower($u->kategori ?? '');
                return match ($kat) {
                    'dokumen', 'document' => '<span class="badge" style="background:#0b1626; color:#fff"><i class="bi bi-file-earmark-text me-1"></i>Dokumen</span>',
                    'pedoman' => '<span class="badge bg-primary"><i class="bi bi-book me-1"></i>Pedoman</span>',
                    'panduan' => '<span class="badge bg-info text-dark"><i class="bi bi-compass me-1"></i>Panduan</span>',
                    'template' => '<span class="badge" style="background:#7c3aed; color:#fff"><i class="bi bi-brush me-1"></i>Template</span>',
                    'image' => '<span class="badge" style="background:#047857; color:#fff"><i class="bi bi-image me-1"></i>Image</span>',
                    'video' => '<span class="badge bg-primary"><i class="bi bi-camera-video me-1"></i>Video</span>',
                    'audio' => '<span class="badge bg-warning text-dark"><i class="bi bi-music-note-beamed me-1"></i>Audio</span>',
                    default => '<span class="badge bg-secondary">'.e(ucfirst($u->kategori ?: 'Dokumen')).'</span>',
                };
            })
            ->addColumn('file_info', function ($u) {
                $source = $u->file_path
                    ? '<span class="badge bg-info-subtle text-primary border me-1">File Upload</span>'
                    : ($u->file_url ? '<span class="badge bg-secondary-subtle text-dark border me-1">External Link</span>' : '');
                $size = $u->file_size ? '<span class="text-muted small">('.e($u->file_size).')</span>' : '';

                return ($source.$size) ?: '<span class="text-muted small">-</span>';
            })
            ->addColumn('tautan', function ($u) {
                $url = $u->download_url;
                if ($url && $url !== '#') {
                    return '<a href="'.$url.'" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center gap-1" style="font-size:12px; background:#0b1626; border:1px solid #0b1626">
                                <i class="bi bi-file-earmark-text-fill"></i> Document
                            </a>';
                }

                return '<span class="text-muted small"># (Belum Ada Link)</span>';
            })
            ->addColumn('urutan', fn ($u) => '<span class="badge bg-secondary">'.$u->urutan.'</span>')
            ->addColumn('is_active', function ($u) {
                return $u->is_active
                    ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>'
                    : '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function ($unduhan) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';
                $btn .= '<a href="'.route('unduhan.edit', $unduhan->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';
                $btn .= '<form action="'.route('unduhan.destroy', $unduhan->id).'"
                              method="POST" class="m-0 form-delete-unduhan">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="button"
                                   class="btn btn-sm btn-danger"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus"
                                   data-name="'.htmlspecialchars($unduhan->judul, ENT_QUOTES, 'UTF-8').'"
                                   onclick="confirmDeleteUnduhan(event, this)">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                          </button>
                         </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['judul', 'kategori', 'file_info', 'tautan', 'urutan', 'is_active', 'action']);
    }

    /**
     * @return QueryBuilder<Unduhan>
     */
    public function query(Unduhan $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'judul', 'kategori', 'file_path', 'file_url', 'file_size', 'deskripsi', 'urutan', 'is_active'])
            ->orderBy('kategori')
            ->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('unduhan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5, 'asc')
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
            Column::make('DT_RowIndex')->title('No')->width('5%')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('judul')->title('Nama Document')->width('32%'),
            Column::make('kategori')->title('Kategori')->width('12%')->addClass('text-center'),
            Column::computed('file_info')->title('Format / Ukuran')->width('14%')->addClass('text-center'),
            Column::computed('tautan')->title('Link Document')->width('15%')->addClass('text-center'),
            Column::make('urutan')->title('Urutan')->width('7%')->addClass('text-center'),
            Column::make('is_active')->title('Status')->width('7%')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('8%')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Unduhan_'.date('YmdHis');
    }
}
