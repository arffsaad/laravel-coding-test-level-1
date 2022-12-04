@extends('layouts.app')

@section('content')
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">World Cup API</p>
    {{--dropdown--}}
    <div class="dropdown">
        <a id="teamSelected" class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Select Team
        </a>
      
        <ul class="dropdown-menu" id="teamsDropdown">
          <li><a class="dropdown-item" href="#">Loading...</a></li>
        </ul>
    </div><br>
    <table class="table table-light table-striped table-bordered border-dark">
        <tr>
            <th scope="col" width="15%">Country</th>
            <td id="cName"></td>
        </tr>
        <tr>
            <th scope="col" width="15%">Country Code</th>
            <td id="cCode"></td>
        </tr>
        <tr>
            <th scope="col" width="15%">Group</th>
            <td id="cGroup"></td>
        </tr>
        <tr>
            <th scope="col" width="15%">Qualified to KO Stage?</th>
            <td id="cStanding"></td>
        </tr>
        <tr>
            <th scope="col" width="15%">Flag</th>
            <td id="cFlag"><img height="50px" src=https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Flag_with_question_mark.svg/2560px-Flag_with_question_mark.svg.png></td>
    </table>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: '/api/worldcup/teams/',
            type: 'GET',
            dataType: 'json',
            success: function(response){
                $('#teamsDropdown').empty();
                $.each(response, function(i, item) {
                    $('#teamsDropdown').append($('<li><a class="dropdown-item" id="' + item.id + '" name="' + item.name_en + '">' + item.name_en + '</a></li>'));
                });
            }
        });
        $(document).on('click', '.dropdown-item', function(){   
            var selected = $(this).attr('name');   
            $('#teamSelected').text(selected);
            $('#cName').html('<label>Loading...</label>');
            $('#cCode').html('<label>Loading...</label>');
            $('#cGroup').html('<label>Loading...</label>');
            $('#cStanding').html('<label>Loading...</label>');
            $('#cFlag').html('<img height="50px" src=https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Flag_with_question_mark.svg/2560px-Flag_with_question_mark.svg.png>');
            $.ajax({
                dataType: 'json',
                url: '/api/worldcup/teams/',
                type: 'POST',
                data: {
                    id: $(this).attr('id')
                },
                success: function(response){
                    // change value of cName
                    $('#cName').html('<label>' + response[0]['name_en'] + '</label>');
                    $('#cCode').html('<label>' + response[0]['fifa_code'] + '</label>');
                    $('#cGroup').html('<label>' + response[0]['groups'] + '</label>');
                    $('#cStanding').html('<label>' + response[1]['qualify'] + '</label>');
                    $('#cFlag').html('<img height="50px" src=' + response[0]['flag'] + '>');
                    // console.log(response);
                },
                error: function(response){
                    console.log(response);
                }
            });
        });
    });
    
</script>
@endsection
