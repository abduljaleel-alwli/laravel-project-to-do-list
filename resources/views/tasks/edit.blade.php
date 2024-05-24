@extends('layouts.app')

@section('content')
    <h1>تعديل مهمة</h1>
    <form action="{{ route('tasks.update', $task) }}" method="post">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $task->name }}">
        <textarea name="comment" placeholder="التعليق">{{ $task->comment }}</textarea>
        <select name="status">
            <option value="New" {{ $task->status === 'New' ? 'selected' : '' }}>جديدة</option>
            <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>قيد التنفيذ</option>
            <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>مكتملة</option>
        </select>
        <input type="date" name="due_date" value="{{ $task->due_date }}">
        <button type="submit">تعديل</button>
    </form>
@endsection
