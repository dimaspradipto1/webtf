<?php

namespace App\DataTables;

use App\Models\DesainGrafis;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DesainGrafisDataTable extends DataTable
{
    /**
     * @param  QueryBuilder<DesainGrafis>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('preview', function ($dg) {
                if ($dg->gambar_preview) {
                    return '<img src="'.asset('storage/'.$dg->gambar_preview).'" alt="Preview" class="rounded shadow-sm" style="width: 70px; height: 38px; object-fit: cover;">';
                }

                return '<div class="rounded shadow-sm d-flex align-items-center justify-content-center text-white font-monospace" style="width: 70px; height: 38px; background: '.($dg->warna_gradient ?: '#0b6828').'; font-size: 9px; font-weight: bold;">PREVIEW</div>';
            })
            ->addColumn('judul', function ($dg) {
                $html = '<div class="fw-bold text-dark">'.e($dg->judul).'</div>';
                if ($dg->deskripsi) {
                    $html .= '<div class="text-muted small" style="font-size: 11px;">'.e($dg->deskripsi).'</div>';
                }

                return $html;
            })
            ->addColumn('kategori', function ($dg) {
                return match ($dg->kategori) {
                    'audit' => '<span class="badge" style="background:#044b1c; color:#fff"><i class="bi bi-geo-alt-fill me-1"></i>Auditorium lt. 4</span>',
                    'sidang' => '<span class="badge bg-primary"><i class="bi bi-display me-1"></i>Ruang Sidang lt. 2</span>',
                    'dekanat' => '<span class="badge" style="background:#0284c7; color:#fff"><i class="bi bi-tv me-1"></i>Rapat Dekanat</span>',
                    'spanduk' => '<span class="badge" style="background:#d97706; color:#fff"><i class="bi bi-flag-fill me-1"></i>Banner / Spanduk</span>',
                    default => '<span class="badge bg-secondary">'.e(ucfirst($dg->kategori)).'</span>',
                };
            })
            ->addColumn('canva_url', function ($dg) {
                if ($dg->canva_url) {
                    return '<a href="'.e($dg->canva_url).'" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 py-1" style="font-size: 11.5px;">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Buka Canva
                            </a>';
                }

                return '<span class="text-muted small">-</span>';
            })
            ->addColumn('urutan', fn ($dg) => '<span class="badge bg-secondary">'.$dg->urutan.'</span>')
            ->addColumn('is_active', function ($dg) {
                return $dg->is_active
                    ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>'
                    : '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';
            })
            ->addColumn('action', function ($dg) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';
                $btn .= '<a href="'.route('desain-grafis.edit', $dg->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';
                $btn .= '<form action="'.route('desain-grafis.destroy', $dg->id).'"
                              method="POST" class="m-0 form-delete-desain-grafis">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="button"
                                   class="btn btn-sm btn-danger"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus"
                                   data-name="'.htmlspecialchars($dg->judul, ENT_QUOTES, 'UTF-8').'"
                                   onclick="confirmDeleteDesainGrafis(event, this)">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                          </button>
                         </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['preview', 'judul', 'kategori', 'canva_url', 'urutan', 'is_active', 'action']);
    }

    /**
     * @return QueryBuilder<DesainGrafis>
     */
    public function query(DesainGrafis $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'judul', 'kategori', 'badge_teks', 'spesifikasi', 'deskripsi', 'canva_url', 'gambar_preview', 'warna_gradient', 'urutan', 'is_active'])
            ->orderBy('kategori')
            ->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('desaingrafis-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->width(40)->addClass('text-center'),
            Column::computed('preview')->title('Preview')->orderable(false)->searchable(false)->width(90)->addClass('text-center'),
            Column::make('judul')->title('Judul Templat'),
            Column::make('kategori')->title('Kategori Ruangan')->addClass('text-center'),
            Column::computed('canva_url')->title('Tautan Canva')->addClass('text-center'),
            Column::make('urutan')->title('Urutan')->addClass('text-center')->width(60),
            Column::make('is_active')->title('Status')->addClass('text-center')->width(80),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'DesainGrafis_'.date('YmdHis');
    }
}
