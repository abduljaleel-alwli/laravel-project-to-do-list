@extends('layouts.app')

@section('content')
    <h1>إنشاء مهمة جديدة</h1>
    <form action="{{ route('tasks.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="اسم المهمة">
        <textarea name="comment" placeholder="التعليق"></textarea>
        <select name="status">
            <option value="New">جديدة</option>
            <option value="In Progress">قيد التنفيذ</option>
            <option value="Completed">مكتملة</option>
        </select>
        <input type="date" name="due_date">
        <button type="submit">إنشاء</button>
    </form>
@endsection
