<?php
?>
<div class="row">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Test Students Info</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-user-review" class="table table-hover">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Date Start</th>
                        <th>Date End</th>
                        <th>Time</th>
                        <th>Ip Conect</th>
                        <th>Suspicious activity</th>
                        <th>Score</th>
                        <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($user_status){
                        foreach ($user_status AS $student){
                            if(is_null($student['score'])){
                                echo "<tr>";
                            } else {
                                echo "<tr class=''>";
                            }
                            ?>
                            <td><?php echo $student['user']->fullName() ?></td>
                            <td><?php echo $student['date_start'] ?></td>
                            <td><?php
                                if(is_null($student['date_end'])){
                                    echo "Test in process.";
                                } else {
                                    echo $student['date_end'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(is_null($student['date_end'])){
                                    echo "In Process";
                                } else {
                                    $start = new DateTime($student['date_start']);
                                    $end = new DateTime($student['date_end']);
                                    $difference = date_diff($start, $end);

                                    if($difference->h > 0){
                                        echo $difference->h." h ". $difference->i." m ".$difference->s. " s";
                                    }elseif($difference->i > 0){
                                        echo $difference->i." min ".$difference->s. " sec";
                                    } else {
                                        echo $difference->s ." Seconds";
                                    }

                                }
                                ?>
                            </td>
                            <td><?php
                                if($student['ip_conect'] == $student['user']->getNormal_ip()){
                                    echo "Same Ip as always: ". $student['ip_conect'];
                                } else {
                                    echo "<p class='text-danger'> Diferents IP: Normal: ".$student['user']->getNormal_ip().". <b>Now IP: ".$student['ip_conect']."</b> </p>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(is_null($student['cheats'])){
                                    echo "No Suspicious activity";
                                } else {
                                    echo "<p class='text-danger'>" .$student['cheats']. "</p>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(is_null($student['score'])){
                                    echo "In Process";
                                } else {
                                    echo "<b>" .$student['score']. "</b>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(is_null($student['score'])){
                                    echo "In Process";
                                } else {
                                    echo "<a class='btn btn-success btn-sm' href='".URL."TestController/viewResult/".$test_hash."/".$student['user']->getHash()."/".$course_hash."'> <span class='fa fa-eye'></span> </a>";
                                }
                                ?>
                            </td>
                            </tr>
                            <?php
                        }
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




