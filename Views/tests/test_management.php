<div id="a" data-site="<?php echo URL;?>" class="container-fluid">
    <div class="text-center">
        <h3 class="text-primary">Udate Test</h3>
    </div>
    <div class="row">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Test Questions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="question-test-table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>
                            <th>Position</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Question Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 0;
                        if(!is_null($test->getQuestions())){
                            foreach ($test->getQuestions() as $question){
                                $color = "";
                                $count++;
                                switch ($question->getQuestionType()){
                                    case "simple":
                                        $color = "badge-success";
                                        break;
                                    case "multiple":
                                        $color = "badge-info";
                                        break;
                                    case "written":
                                        $color = "badge-warning";
                                        break;
                                }
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td>".$question->getTitle()."</td>";
                                echo "<td><p>".$question->getText()."</p></td>";
                                echo "<td><span class='badge ".$color." rounded-pill d-inline'>".$question->getQuestionType()."</span></td>";
                                echo "<td>
                                <button type='button' data-id='".$question->getId()."' class='btn btn-view-qest btn-primary btn-sm btn-rounded'>
                                    View
                                </button>
                                <button type='button' data-test-id='".$test->getId()."' data-id='".$question->getId()."' class='btn btn-danger  btn-remove-test btn-sm btn-rounded'>
                                    Delete
                                </button>
                                    </td>";
                                echo "</tr>";
                            }
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Questions Bank</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="question-bank" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Question Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($questions as $question){
                            $color = "";
                            switch ($question->getQuestionType()){
                                case "simple":
                                    $color = "badge-success";
                                break;
                                case "multiple":
                                    $color = "badge-info";
                                break;
                                case "written":
                                    $color = "badge-warning";
                                break;
                            }
                            echo "<tr>";
                            echo "<td>".$question->getTitle()."</td>";
                            echo "<td><p>".$question->getText()."</p></td>";
                            echo "<td><span class='badge ".$color." rounded-pill d-inline'>".$question->getQuestionType()."</span></td>";
                            echo "<td>
                                <button type='button' data-id='".$question->getId()."' class='btn btn-primary btn-sm btn-rounded btn-view-qest'>
                                    View
                                </button>
                                <button type='button' data-id='".$question->getId()."' class='btn btn-del-question btn-danger btn-sm btn-rounded'>
                                    Delete
                                </button>
                                <button type='button' id='add-question-test' data-test='".$test->getId()."' data-id='".$question->getId()."' class='btn btn-success btn-sm btn-rounded'>
                                    Add
                                </button>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h3 class="text-primary">Create Question</h3>
    </div>
    <div class="row">
        <form action="" method="POST" id="createAnswer" class="row g-3 bg-white">
            <div class="controls  border rounded mb-3">
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input id="title" type="text" name="title" class="form-control" placeholder="Question Title" required="required" data-error="Firstname is required.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="question_type" class="form-label">Question Type</label>
                        <select name='question_type' class="custom-select" id="question_type" required>
                            <option value="" disabled selected>Select Question Type</option>
                            <option value="simple">Simple Answer</option>
                            <option value="multiple"> Multiple Answer</option>
                            <option value="written">Written Answer</option>
                        </select>
                    </div>
                </div>
                <div class="row basicAnswer">
                        <div class='col-md-10 m-auto'>
                            <div class='form-group'>
                                <label for='question_des'>Question Description *</label>
                                <textarea id='question_des' name='question_des' class='form-control bg-white' placeholder='Write your description here.' rows='2'></textarea>
                            </div>
                        </div>
                </div>
                <div class="row" id="content-answer">

                </div>
            </div>
            <div class="row basicAnswer d-none mb-2">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-success" id="createQuestion" value="Create Question"/>
                </div>
            </div>
        </form>
</div>
<!-- MODAL WINDOWS FOR TYPE OF THE QUESTIONS -->
<div class="modal" id="viewQuestion" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-view-question">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS FOR VIEWTHE QUESTIONS -->
<div class="modal" id="editQuestion" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-xxl-down	">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://js.nicedit.com/nicEdit-latest.js"
            type="text/javascript"> </script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            bkLib.onDomLoaded(textAreaG);
        });
        function textAreaG() {
            nicEditors.allTextAreas()
        }
    </script>
