<?php

namespace App\DataTables;

use App\Models\Kurikulum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KurikulumDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('prodi', function ($k) {
                return '<span class="badge bg-light text-dark border fw-bold">'.e($k->prodi?->judul ?? $k->prodi_nama ?? 'Semua Prodi').'</span>';
            })
            ->addColumn('semester_badge', function ($k) {
                return '<span class="badge" style="background:#823ca2; color:#fff;">Semester '.$k->semester_romawi.'</span>';
            })
            ->addColumn('sks_badge', function ($k) {
                return '<span class="badge bg-warning text-dark fw-bold">'.$k->sks.' SKS</span>';
            })
            ->addColumn('rps_action', function ($k) {
                if (! empty($k->file_rps)) {
                    return '<a href="'.asset('storage/'.$k->file_rps).'" target="_blank" class="btn btn-sm btn-outline-danger py-1 px-2" style="font-size:11.5px; white-space:nowrap; display:inline-flex; align-items:center; justify-content:center; gap:4px; font-weight:600;" title="Download File RPS">
                                <i class="bi bi-file-earmark-pdf-fill"></i> File RPS
                            </a>';
                }
                if (! empty($k->link_rps)) {
                    return '<a href="'.e($k->link_rps).'" target="_blank" class="btn btn-sm btn-warning py-1 px-2" style="font-size:11.5px; white-space:nowrap; display:inline-flex; align-items:center; justify-content:center; gap:4px; background:#f9dc4b; color:#000000; border:none; font-weight:700;" title="Buka Link RPS">
                                <i class="bi bi-box-arrow-up-right"></i> Link RPS
                            </a>';
                }

                return '<span class="text-muted small italic">-</span>';
            })
            ->addColumn('status', function ($k) {
                return $k->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-secondary">Nonaktif</span>';
            })
            ->addColumn('action', function ($k) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('kurikulum.edit', $k->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('kurikulum.destroy', $k->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus matakuliah ini?\')">'
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
            ->filterColumn('prodi', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('prodi', function ($sub) use ($keyword) {
                        $sub->where('judul', 'like', "%{$keyword}%");
                    })->orWhere('kurikulums.prodi_nama', 'like', "%{$keyword}%");
                });
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['prodi', 'semester_badge', 'sks_badge', 'rps_action', 'status', 'action']);
    }

    public function query(Kurikulum $model): QueryBuilder
    {
        $query = $model->newQuery()->with('prodi');

        if (request()->filled('prodi_id')) {
            $query->where('layanan_id', request('prodi_id'));
        }

        if (request()->filled('semester')) {
            $query->where('semester', request('semester'));
        }

        return $query->orderBy('layanan_id')->orderBy('semester')->orderBy('urutan')->orderBy('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kurikulum-table')
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
            Column::make('DT_RowIndex')->title('No')->width('5%')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('prodi')->title('Program Studi')->searchable(true),
            Column::make('semester_badge')->title('Semester')->addClass('text-center'),
            Column::make('kode_mk')->title('Kode MK'),
            Column::make('nama_mk')->title('Nama Matakuliah'),
            Column::make('sks_badge')->title('SKS')->addClass('text-center')->width('70px'),
            Column::make('kategori')->title('Kategori')->addClass('text-center')->width('90px'),
            Column::make('rps_action')->title('RPS')->addClass('text-center')->width('110px'),
            Column::make('status')->title('Status')->addClass('text-center')->width('80px'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('90px')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Kurikulum_'.date('YmdHis');
    }
}
