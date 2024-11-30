@extends('admin.layouts.master')
@section('title')
    Thuộc tính biến thể
@endsection
@section('css')
    <style>
        .modal-backdrop {
            z-index: -1;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h3 class="title-5 m-b-35">Màu sắc</h3>
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="rs-select2--light rs-select2--sm">
                            <select class="js-select2" name="time">
                                <option selected="selected">Sắp xếp</option>
                                <option value="">Mới nhất</option>
                                <option value="">Cũ nhất</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        <button class="au-btn-filter">
                            <i class="zmdi zmdi-filter-list"></i>Lọc</button>
                    </div>
                    <form class="au-form-icon" action="" method="GET">
                        <input class="au-input--w200 au-input--style2" name="search" value="{{ request('search') }}"
                            type="text" placeholder="Tìm kiếm..." />
                        <button class="au-btn--submit2" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal"
                            data-target="#addColorModal">
                            <i class="zmdi zmdi-plus"></i>Thêm</button>
                    </div>
                    <!-- Modal thêm màu sắc -->
                </div>
                <div class="container mt-5">

                    <!-- Modal thêm màu sắc -->
                    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addColorModalLabel">Thêm màu sắc mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.products.variants.colors.store') }} " method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="color_name">Tên màu:</label>
                                            <input type="text" class="form-control" id="color_name" name="name">
                                            <p class="text-danger" id="name_error" style="display: none;">Tên màu là bắt
                                                buộc!</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="color_code">Mã màu:</label>
                                            <input type="text" class="form-control" id="color_code" name="code_color"
                                                placeholder="#ff0000">
                                            <p class="text-danger" id="color_code_error" style="display: none;">Mã màu là
                                                bắt buộc!</p>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="createColor">Lưu màu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Màu sắc</th>
                                    <td>Tên màu</td>
                                    <th>Mã mầu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colors as $item)
                                    <tr class="tr-shadow">
                                        <td>{{ $item['id'] }}</td>
                                        <td>
                                            <div style="width: 50px; height: 50px; background-color: {{ $item->code_color }};"
                                                class="border shadow ">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->code_color }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                {{-- Sửa --}}
                                                <button class="item mr-2" data-toggle="modal"
                                                    data-target="#editSizeModal{{ $item->id }}">
                                                    <i class="zmdi zmdi-edit" data-toggle="tooltip" data-placement="top"
                                                        title="Edit"></i>
                                                </button>

                                                <!-- Modal chỉnh sửa màu sắc -->
                                                <div class="modal fade" id="editSizeModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editSizeModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editSizeModalLabel{{ $item->id }}">Chỉnh sửa
                                                                    màu sắc</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.products.variants.colors.update', $item->id) }} "
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="color_name">Tên màu:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="color_name" name="name"
                                                                            value="{{ $item->name }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="color_code">Mã màu:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="color_code" name="code_color"
                                                                            value="{{ $item->code_color }}">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Cập
                                                                        nhật màu</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Xóa  --}}
                                                <form
                                                    action="{{ route('admin.products.variants.colors.delete', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="title-5 m-b-35">Size</h3>
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="rs-select2--light rs-select2--sm">
                            <select class="js-select2" name="time">
                                <option selected="selected">Sắp xếp</option>
                                <option value="">Mới nhất</option>
                                <option value="">Cũ nhất</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        <button class="au-btn-filter">
                            <i class="zmdi zmdi-filter-list"></i>Lọc</button>
                    </div>
                    <form class="au-form-icon" action="" method="GET">
                        <input class="au-input--w200 au-input--style2" name="search" value="{{ request('search') }}"
                            type="text" placeholder="Tìm kiếm..." />
                        <button class="au-btn--submit2" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal"
                            data-target="#addSizeModal">
                            <i class="zmdi zmdi-plus"></i>Thêm</button>
                    </div>
                    <!-- Modal thêm màu sắc -->
                </div>
                <div class="container mt-5">

                    <!-- Modal thêm Size -->
                    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSizeModalLabel">Thêm size mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.products.variants.sizes.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Size:</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                            <p class="text-danger" id="size_error" style="display: none;">Tên màu là bắt
                                                buộc!</p>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="createSize">Lưu size</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <td>Size</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $item)
                                    <tr class="tr-shadow">
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                {{-- Sửa --}}
                                                <button class="item mr-2" data-toggle="modal"
                                                    data-target="#editSize{{ $item->id }}">
                                                    <i class="zmdi zmdi-edit" data-toggle="tooltip" data-placement="top"
                                                        title="Edit"></i>
                                                </button>

                                                <!-- Modal chỉnh Size -->
                                                <div class="modal fade" id="editSize{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editSizeModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editSizeModalLabel{{ $item->id }}">Chỉnh sửa
                                                                    Size</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.products.variants.sizes.update', $item->id) }} "
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="color_name">Size:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="color_name" name="name"
                                                                            value="{{ $item->name }}">
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary">Cập
                                                                        nhật Size</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Xóa  --}}
                                                <form
                                                    action="{{ route('admin.products.variants.sizes.delete', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('js')
        <script>
            document.getElementById('createColor').addEventListener('click', function(event) {
                let colorName = document.getElementById('color_name').value.trim();
                let colorCode = document.getElementById('color_code').value.trim();

                let hasError = false;

                // Validate tên màu 
                if (colorName === '') {
                    document.getElementById('name_error').style.display = 'block';
                    hasError = true;
                } else {
                    document.getElementById('name_error').style.display = 'none';
                }

                // Validate Mã Màu (phải có định dạng hex)
                let colorCodePattern = /^#[0-9A-F]{6}$/i;
                if (!colorCodePattern.test(colorCode)) {
                    document.getElementById('color_code_error').style.display = 'block';
                    hasError = true;
                } else {
                    document.getElementById('color_code_error').style.display = 'none';
                }

                // Nếu có lỗi, ngăn chặn việc submit form
                if (hasError) {
                    event.preventDefault();
                }
            })

            document.getElementById('createSize').addEventListener('click', function(event) {
                let colorName = document.getElementById('name').value.trim();

                let hasError = false;

                // Validate tên màu 
                if (colorName === '') {
                    document.getElementById('size_error').style.display = 'block';
                    hasError = true;
                } else {
                    document.getElementById('size_error').style.display = 'none';
                }

                // Nếu có lỗi, ngăn chặn việc submit form
                if (hasError) {
                    event.preventDefault();
                }
            })
        </script>
    @endsection
