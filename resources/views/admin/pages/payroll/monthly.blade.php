@extends('admin.layouts.app')

@section('title')
    Bảng lương tháng {{ $month->format('m/Y') }}
@endsection

@section('content')
<section class="content">
    <h3>Bảng lương tháng {{ $month->format('m/Y') }}</h3>

    @if ($rows->isEmpty())
        <div class="alert alert-warning">Chưa có dữ liệu lương cho tháng này</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th>Tên NV</th>
                        <th>Lương cơ bản/ngày</th>
                        <th>Tổng thu nhập</th>
                        <th>Thực lĩnh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->employee_id }}</td>
                            <td>{{ $row->admin->name ?? '' }}</td>
                            <td>{{ $row->base_salary_by_days }}</td>
                            <td>{{ $row->total_income }}</td>
                            <td>{{ $row->net_income }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
