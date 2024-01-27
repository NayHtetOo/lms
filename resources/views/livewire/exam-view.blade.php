<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-full">

        @include('nav')

        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-lg">
                {{-- <div>{{ $this->exams }}</div>
                <div>{{ $courseID }}</div> --}}
                <div>
                    <a href="/course_view/{{ $this->exams->course_id }}" class="text-blue-700 underline">{{ $courseID }}</a> / {{ $this->exams->exam_name }}
                </div> <br>
                <h2 class="text-2xl mb-1 font-bold">{{ $this->exams->exam_name }}</h2>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="border-b-2">
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="">Start Date</th>
                                <th scope="col" class="">End Date</th>
                                <th scope="col" class="">Duration (minutes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td  scope="col" class="px-6 py-3"> {{ $this->exams->description }} </td>
                            <td> {{ $this->exams->start_date_time }} </td>
                            <td> {{ $this->exams->end_date_time }} </td>
                            <td> {{ $this->exams->duration }} minutes</td>
                        </tbody>
                    </table>
                </div>
                <div class="m-3">
                </div>
            </div>

        </div>
    </div>
</body>
</html>

