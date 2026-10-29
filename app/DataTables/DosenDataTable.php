<?php

namespace App\DataTables;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DosenDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($d) {
                return '<input type="checkbox" name="dosen_ids[]" value="'.$d->id.'" class="form-check-input check-item-dosen" style="cursor:pointer;">';
            })
            ->addColumn('DT_RowIndex', '')
            ->addColumn('prodi', function ($d) {
                return '<span class="badge bg-light text-dark border fw-bold">'.e($d->prodi?->judul ?? $d->prodi_nama ?? '-').'</span>';
            })
            ->editColumn('nama_dosen', function ($d) {
                return '<div class="fw-bold text-dark text-nowrap" style="min-width: 220px;">'.e($d->nama_dosen).'</div>';
            })
            ->editColumn('jabatan_fungsional', function ($d) {
                if (! empty($d->jabatan_fungsional)) {
                    return '<span class="badge text-nowrap" style="background:#823ca2; color:#fff; font-size:11.5px; padding:5px 10px;">'.e($d->jabatan_fungsional).'</span>';
                }

                return '<span class="text-muted small">-</span>';
            })
            ->editColumn('nidn', function ($d) {
                return ! empty($d->nidn) ? '<span class="font-monospace fw-semibold text-nowrap">'.e($d->nidn).'</span>' : '<span class="text-muted">-</span>';
            })
            ->editColumn('nuptk', function ($d) {
                return ! empty($d->nuptk) ? '<span class="font-monospace fw-semibold text-nowrap">'.e($d->nuptk).'</span>' : '<span class="text-muted">-</span>';
            })
            ->addColumn('link_profile', function ($d) {
                if (! empty($d->link)) {
                    return '<a href="'.e($d->link).'" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2 text-nowrap" style="font-size:11.5px;" title="Lihat Profil Online">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Profil
                            </a>';
                }

                return '<span class="text-muted small">-</span>';
            })
            ->addColumn('status', function ($d) {
                return $d->is_active
                    ? '<span class="badge bg-success text-nowrap">Aktif</span>'
                    : '<span class="badge bg-secondary text-nowrap">Nonaktif</span>';
            })
            ->addColumn('action', function ($d) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                $btn .= '<a href="'.route('dosen.edit', $d->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                $btn .= '<form action="'.route('dosen.destroy', $d->id).'"
                              method="POST" class="m-0 form-delete-dosen">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button"
                                   class="btn btn-sm btn-danger btn-delete-dosen-item"
                                   style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                                   title="Hapus"
                                   data-nama="'.e($d->nama_dosen).'">
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
                    })->orWhere('dosens.prodi_nama', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('nama_dosen', function ($query, $keyword) {
                $query->where('dosens.nama_dosen', 'like', "%{$keyword}%");
            })
            ->filterColumn('jabatan_fungsional', function ($query, $keyword) {
                $query->where('dosens.jabatan_fungsional', 'like', "%{$keyword}%");
            })
            ->filterColumn('nidn', function ($query, $keyword) {
                $query->where('dosens.nidn', 'like', "%{$keyword}%");
            })
            ->filterColumn('nuptk', function ($query, $keyword) {
                $query->where('dosens.nuptk', 'like', "%{$keyword}%");
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['checkbox', 'prodi', 'nama_dosen', 'jabatan_fungsional', 'nidn', 'nuptk', 'link_profile', 'status', 'action']);
    }

    public function query(Dosen $model): QueryBuilder
    {
        $query = $model->newQuery()->with('prodi');

        if (request()->filled('prodi_id')) {
            $query->where('layanan_id', request('prodi_id'));
        }

        return $query->orderBy('layanan_id')->orderBy('urutan')->orderBy('nama_dosen');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('dosen-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
            ])
            ->orderBy(2)
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
            Column::computed('checkbox')
                ->title('<input type="checkbox" id="check-all-dosen" class="form-check-input" style="cursor:pointer;" title="Pilih Semua">')
                ->exportable(false)
                ->printable(false)
                ->width('40px')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('DT_RowIndex')->title('No')->width('50px')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('nama_dosen')->title('Nama Dosen & Gelar')->width('260px')->searchable(true),
            Column::make('prodi')->title('Program Studi')->width('220px')->searchable(true),
            Column::make('jabatan_fungsional')->title('Jabatan Fungsional')->width('160px')->addClass('text-center')->searchable(true),
            Column::make('nidn')->title('NIDN')->width('130px')->addClass('text-center')->searchable(true),
            Column::make('nuptk')->title('NUPTK')->width('150px')->addClass('text-center')->searchable(true),
            Column::make('link_profile')->title('Link Profil')->width('100px')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('status')->title('Status')->width('90px')->addClass('text-center')->searchable(false),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('90px')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Dosen_'.date('YmdHis');
    }
}
