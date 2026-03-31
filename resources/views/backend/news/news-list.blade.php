@extends('backend.master')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>News List</h3>
            <a href="{{ url('/admin/news/create') }}" class="btn btn-primary">+ Add News</a>
        </div>

       <table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>SL</th>
            <th>Title</th>
            <th>Image</th>
            <th>Published By</th>
            <th>Published Date</th>
            <th>Status</th>
            <th width="200">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($newspaper as $news)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $news->title }}</td>
                <td>
                    <img src="{{ asset('backend/images/news/' . $news->image) }}" width="80" height="60" class="rounded">
                </td>
                <td>{{ $news->published_by }}</td>
                <td>{{ $news->created_at->format('d/m/y') }}</td>
                <td>
                    <form action="{{ route('news.status', $news->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @if ($news->status == 1)
                            <button type="submit" class="badge bg-success border-0">Published</button>
                        @else
                            <button type="submit" class="badge bg-danger border-0">Unpublished</button>
                        @endif
                    </form>
                </td>
                <td>
                    <a href="{{url('/admin/news/edit/'.$news->id)}}" class="btn btn-sm btn-info"><span class="mdi mdi-pencil"></span></a>
                        <a href="{{url('/admin/news/delete/'.$news->id)}}" type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this news?')"><span class="mdi mdi-delete"></span></a>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>
@endsection
