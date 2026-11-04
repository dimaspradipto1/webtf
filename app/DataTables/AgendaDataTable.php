<?php

namespace App\DataTables;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AgendaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Agenda>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->editColumn('title', function ($agenda) {
                $html = '<div class="fw-semibold text-dark">'.e($agenda->title).'</div>';
                if ($agenda->description) {
                    $clean = trim(html_entity_decode(strip_tags($agenda->description), ENT_QUOTES, 'UTF-8'));
                    if (! empty($clean)) {
                        $html .= '<div class="text-muted small mt-1" style="font-size:12px; line-height: 1.4;">'.e(\Illuminate\Support\Str::limit($clean, 90)).'</div>';
                    }
                }
                if ($agenda->link_url) {
                    $html .= '<div class="mt-1"><a href="'.e($agenda->link_url).'" target="_blank" class="badge bg-light text-primary border text-decoration-none" style="font-size:11px"><i class="bi bi-box-arrow-up-right me-1"></i>Tautan Info</a></div>';
                }

                return $html;
            })
            ->filterColumn('title', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('date_text', function ($agenda) {
                return '<div class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="bi bi-calendar4-week me-1"></i>'.e($agenda->date_text).'</div>';
            })
            ->editColumn('location', function ($agenda) {
                return $agenda->location ? '<span class="text-dark small"><i class="bi bi-geo-alt-fill text-danger me-1"></i>'.e($agenda->location).'</span>' : '<span class="text-muted small">-</span>';
            })
            ->editColumn('urutan', function ($agenda) {
                return '<span class="badge bg-secondary px-2 py-1">'.e($agenda->urutan).'</span>';
            })
            ->addColumn('status', function ($agenda) {
                if ($agenda->is_active) {
                    return '<span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>';
                }

                return '<span class="badge bg-secondary px-2 py-1">Nonaktif</span>';
            })
            ->filterColumn('status', function ($query, $keyword) {
                $kw = strtolower($keyword);
                if (str_contains($kw, 'aktif') && ! str_contains($kw, 'non')) {
                    $query->where('is_active', true);
                } elseif (str_contains($kw, 'non')) {
                    $query->where('is_active', false);
                }
            })
            ->addColumn('action', function ($agenda) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('agenda.edit', $agenda->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('agenda.destroy', $agenda->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus agenda ini?\')">'
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
            ->rawColumns(['title', 'date_text', 'location', 'urutan', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Agenda>
     */
    public function query(Agenda $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('urutan')->latest('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('agenda-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(4, 'asc')
            ->selectStyleSingle()
            ->parameters([
                'pageLength' => 10,
                'pagingType' => 'simple_numbers',
                'language' => [
                    'search' => 'Cari:',
                    'searchPlaceholder' => 'Cari agenda...',
                    'lengthMenu' => '_MENU_ data per halaman',
                    'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    'infoEmpty' => 'Menampilkan 0 sampai 0 dari 0 entri',
                    'infoFiltered' => '(disaring dari _MAX_ total entri)',
                    'zeroRecords' => 'Tidak ditemukan data yang sesuai',
                    'emptyTable' => 'Tidak ada data agenda tersedia',
                    'paginate' => [
                        'first' => '«',
                        'last' => '»',
                        'previous' => '‹',
                        'next' => '›',
                    ],
                ],
            ])
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
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
                ->title('Nama Agenda / Kegiatan')
                ->addClass('align-middle'),
            Column::make('date_text')
                ->title('Waktu / Jadwal')
                ->width(180)
                ->addClass('text-center align-middle'),
            Column::make('location')
                ->title('Lokasi')
                ->width(160)
                ->addClass('align-middle'),
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
        return 'Agenda_'.date('YmdHis');
    }
}

