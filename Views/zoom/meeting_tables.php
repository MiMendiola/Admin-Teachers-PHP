<?php
?>
<table id="usr-table" class="table table-hover">
    <thead>
    <tr>
        <th>Meeting Title</th>
        <th>Start Time</th>
        <th>Duration</th>
        <th>Create At</th>
        <th>URL Join</th>
        <th>Acctions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!is_null($reuniones)){

        foreach($reuniones AS $reunion){
            //save the Users Id
            echo "<tr>";

            echo "<td>".$reunion->topic."</td>";
            echo "<td>".$reunion->start_time."</td><td>".$reunion->duration."mins</td><td>".date("Y-m-d H:i:s",strtotime($reunion->created_at))."</td>";
            echo "<td> <a href='".$reunion->join_url."' target='_blank'>".$reunion->join_url."</a></td>";

            echo "<td><button class='btn btn-danger btn-dmeet' title='Delete Meeting' data-meet-id='".$reunion->id."'> <span class='fas fa-trash-alt'></span>
                            </button>
                            <button class='btn btn-warning btn-umeet' title='Update Meeting' data-topic='".$reunion->topic."'  data-duration='".$reunion->duration."' data-date='".$reunion->start_time."'  data-meet-id='".$reunion->id."'> <span class='fas fa-pen'></span>
                            </button>
                            </td>";

            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

