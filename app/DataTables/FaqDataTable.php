<?php

namespace App\DataTables;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FaqDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Faq>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('question', function ($faq) {
                return e($faq->question);
            })
            ->addColumn('answer', function ($faq) {
                $clean = trim(html_entity_decode(strip_tags($faq->answer ?? ''), ENT_QUOTES, 'UTF-8'));

                return e(Str::limit($clean, 100));
            })
            ->addColumn('category', function ($faq) {
                $badges = [
                    'akademik' => '<span class="badge bg-primary px-2 py-1">Akademik & Kurikulum</span>',
                    'pendaftaran' => '<span class="badge bg-warning text-dark px-2 py-1">Pendaftaran & PMB</span>',
                    'fasilitas' => '<span class="badge bg-success px-2 py-1">Fasilitas & Lab</span>',
                    'karir' => '<span class="badge bg-info text-dark px-2 py-1">Karir & Magang</span>',
                ];

                return $badges[$faq->category] ?? '<span class="badge bg-secondary px-2 py-1">'.e(ucfirst($faq->category)).'</span>';
            })
            ->addColumn('action', function ($faq) {
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap:5px">';

                // Tombol Edit
                $btn .= '<a href="'.route('faq.edit', $faq->id).'"
                            class="btn btn-sm btn-warning text-white"
                            style="width:30px;height:30px;display:flex;align-items:center;justify-content:center"
                            title="Edit">
                            <i class="bi bi-pencil-fill" style="font-size:12px"></i>
                         </a>';

                // Tombol Hapus
                $btn .= '<form action="'.route('faq.destroy', $faq->id).'"
                              method="POST" class="m-0"
                              onsubmit="return confirm(\'Yakin ingin menghapus FAQ ini?\')">'
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
            ->rawColumns(['action', 'category']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Faq>
     */
    public function query(Faq $model): QueryBuilder
    {
        return $model->newQuery()->select(['id', 'question', 'answer', 'category']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('faq-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->width('5%')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),

            Column::make('question')
                ->title('Pertanyaan'),

            Column::make('answer')
                ->title('Jawaban'),

            Column::make('category')
                ->title('Kategori'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width('10%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Faq_'.date('YmdHis');
    }
}
