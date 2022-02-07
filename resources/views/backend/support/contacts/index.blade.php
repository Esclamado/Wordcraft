@extends('backend.layouts.app')

@section('content')

<div class="card">
    <form id="sort_contacts" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Contact Us Messages') }}</h5>
            </div>
            <div class="col-md-2">
                <div class="input-group input-group-sm">
                    <input type="text" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset class="form-control" placeholder="{{ translate('Type name, email or contact number & Enter') }}">
                </div>
            </div>
        </div>
    </form>

    <div class="card-body overflow-auto">
        <table class="aiz-table" cellspacing="0" width="100%" id="contactusTable">
            <thead>
                <tr>
                    <th>{{ translate('ID') }}</th>
                    <th onclick="sortTable(1)" class="c-pointer">
                        <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                        {{ translate('Full Name') }}
                    </th>
                    <th>{{ translate('Contact Number') }}</th>
                    <th>{{ translate('Email Address') }}</th>
                    <th>{{ translate('IP Address') }}</th>
                    <th>{{ translate('Answered') }}</th>
                    <th class="text-right">{{ translate('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $key => $contact)
                    <tr>
                        <td>{{ ($key + 1) + ($contacts->currentPage() - 1) * $contacts->perPage() }}</td>
                        <td>{{ $contact->full_name }}</td>
                        <td>{{ $contact->contact_number }}</td>
                        <td>{{ $contact->email_address }}</td>
                        <td>{{ $contact->ip_address }}</td>
                        <td>
                            @if ($contact->answered == 0)
                                <span class="badge badge-warning w-auto">
                                    Not yet answered
                                </span>
                            @elseif ($contact->answered == 1)
                                <span class="badge badge-success w-auto">
                                    Answered
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($contact->answered != 1)
                                <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="mark_as_answered('{{ $contact->id }}')" title="{{ translate('Mark as Answered') }}">
                                    <i class="las la-check"></i>
                                </a>
                            @endif
                            <a href="{{ route('contact_us.show', encrypt($contact->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('View Contact Message') }}">
                                <i class="las la-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')

    <script type="text/javascript">
        function mark_as_answered (el) {
            $.post('{{ route('contact_us.mark_as_answered') }}', { _token: '{{ @csrf_token() }}', el: el }, function (data) {
                if (data == 1) {
                    location.reload();
                    AIZ.plugins.notify('success', '{{ translate('Contact Message is marked as answered successfully') }}');
                }

                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong!') }}');
                }
            })
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("contactusTable");
            switching = true;
        
            dir = "asc"; 
       
        while (switching) {
            switching = false;
            rows = table.rows;
    
            for (i = 1; i < (rows.length - 1); i++) {
            
            shouldSwitch = false;
            
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
          
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch= true;
                break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
                }
            }
            }
            if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;      
            } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
            }
        }
        }
    </script>

@endsection
