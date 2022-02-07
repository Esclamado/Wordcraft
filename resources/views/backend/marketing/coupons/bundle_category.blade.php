@if (count($category_ids) > 0)
    <label for="" class="col-sm-4 control-from-label">{{ translate('Bundled Categories') }}</label>
    <div class="col-sm-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td width="50%">{{ translate("Category") }}</td>
                    <td width="25%">{{ translate("Min Quantity") }}</td>
                    <td width="25%">{{ translate("Max Quantity") }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($category_ids as $key => $id)
                    @php
                        $category = \App\Category::where('level', 0)
                            ->findOrFail($id);
                    @endphp

                    <tr>
                        <td>
                            {{ $category->getTranslation('name') }}
                        </td>
                        <td>
                            <input type="number" name="quantity_min_{{ $id }}" min="1" step="1" class="form-control" id="" required>
                        </td>
                        <td>
                            <input type="number" name="quantity_max_{{ $id }}" min="1" step="1" class="form-control" id="" required>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
