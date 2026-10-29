<?php

namespace App\DataTables;

use App\Models\VisiMisi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VisiMisiDataTable extends DataTable
{
    /**
     * @param  QueryBuilder<VisiMisi>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('tipe', function ($vm) {
                return match ($vm->tipe) {
                    'visi' => '<span class="badge bg-primary">Visi</span>',
                    'misi' => '<span class="badge bg-info text-dark">Misi</span>',
                    'tujuan' => '<span class="badge bg-success">Tujuan</span>',
                    'sasaran' => '<span class="badge bg-warning text-dark">Sasaran</span>',
                    default => '<span class="badge bg-secondary">'.e(ucfirst($vm->tipe)).'</span>',
                };
            })
            ->addColumn('isi', fn ($vm) => e(Str::limit(trim(html_entity_decode(strip_tags($vm->isi ?? ''), ENT_QUOTES, 'UTF-8')), 90)))
            ->addColumn('urutan', fn ($vm) => '<span class="badge bg-secondary">'.$vm->urutan.'</span>')
            ->addColumn('action', function ($visimisi) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';
                $btn .= '<a href="'.route('visimisi.edit', $visimisi->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';
                $btn .= '<form action="'.route('visimisi.destroy', $visimisi->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus data ini?\')">'
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
            ->rawColumns(['tipe', 'isi', 'urutan', 'action']);
    }

    /**
     * @return QueryBuilder<VisiMisi>
     */
    public function query(VisiMisi $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'tipe', 'isi', 'urutan'])
            ->orderByRaw("FIELD(tipe, 'visi', 'misi', 'tujuan', 'sasaran')")
            ->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('visimisi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters(['order' => []])
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
            Column::make('tipe')->title('Tipe')->width('10%')->addClass('text-center'),
            Column::make('isi')->title('Isi'),
            Column::make('urutan')->title('Urutan')->width('8%')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width('10%')->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'VisiMisi_'.date('YmdHis');
    }
}
