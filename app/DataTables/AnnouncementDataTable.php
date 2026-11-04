<?php

namespace App\DataTables;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AnnouncementDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Announcement>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('title', function ($item) {
                $html = '<div class="fw-semibold text-dark">'.e($item->title).'</div>';
                if ($item->content) {
                    $clean = trim(html_entity_decode(strip_tags($item->content), ENT_QUOTES, 'UTF-8'));
                    if (! empty($clean)) {
                        $html .= '<div class="text-muted small mt-1" style="font-size:12px; line-height: 1.4;">'.e(\Illuminate\Support\Str::limit($clean, 90)).'</div>';
                    }
                }

                return $html;
            })
            ->addColumn('date', function ($item) {
                return $item->date ? '<span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-calendar3 me-1 text-primary"></i>'.e(Carbon::parse($item->date)->translatedFormat('d F Y')).'</span>' : '-';
            })
            ->addColumn('lampiran_link', function ($item) {
                $parts = [];
                if ($item->file_path) {
                    $parts[] = '<a href="'.asset('storage/'.$item->file_path).'" target="_blank" class="badge bg-danger text-white text-decoration-none px-2 py-1 me-1"><i class="bi bi-file-earmark-pdf me-1"></i>File Lampiran</a>';
                }
                if ($item->link_url) {
                    $parts[] = '<a href="'.e($item->link_url).'" target="_blank" class="badge bg-info text-white text-decoration-none px-2 py-1"><i class="bi bi-link-45deg me-1"></i>Link URL</a>';
                }

                return ! empty($parts) ? implode(' ', $parts) : '<span class="text-muted small">-</span>';
            })
            ->addColumn('urutan', function ($item) {
                return '<span class="badge bg-secondary px-2 py-1">'.e($item->urutan).'</span>';
            })
            ->addColumn('status', function ($item) {
                if ($item->is_active) {
                    return '<span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                }

                return '<span class="badge bg-secondary px-2 py-1">Nonaktif</span>';
            })
            ->addColumn('action', function ($item) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('announcements.edit', $item->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('announcements.destroy', $item->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus pengumuman ini?\')">'
                        .csrf_field().method_field('DELETE')
                        .'<button type="submit"
                                   class="btn btn-sm btn-danger"
                                   style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px"
                                   title="Hapus">
                            <i class="bi bi-trash-fill" style="font-size:12px"></i>
                           </button>
                         </form>';

                $btn .= '</div>';

                return $btn;
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['title', 'date', 'lampiran_link', 'urutan', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Announcement>
     */
    public function query(Announcement $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('urutan')->latest('date');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('announcement-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [
                    Button::make('excel')->text('<i class="bi bi-file-earmark-excel me-1"></i> Excel'),
                    Button::make('pdf')->text('<i class="bi bi-file-earmark-pdf me-1"></i> PDF'),
                    Button::make('print')->text('<i class="bi bi-printer me-1"></i> Cetak'),
                    Button::make('reset')->text('<i class="bi bi-arrow-clockwise me-1"></i> Reset'),
                    Button::make('reload')->text('<i class="bi bi-arrow-repeat me-1"></i> Reload'),
                ],
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(40)
                ->addClass('text-center align-middle'),
            Column::make('title')
                ->title('Judul Pengumuman')
                ->addClass('align-middle'),
            Column::make('date')
                ->title('Tanggal')
                ->width(140)
                ->addClass('text-center align-middle'),
            Column::computed('lampiran_link')
                ->title('Lampiran / Tautan')
                ->width(150)
                ->addClass('text-center align-middle'),
            Column::make('urutan')
                ->title('Urutan')
                ->width(70)
                ->addClass('text-center align-middle'),
            Column::computed('status')
                ->title('Status')
                ->width(90)
                ->addClass('text-center align-middle'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(90)
                ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Announcement_'.date('YmdHis');
    }
}

