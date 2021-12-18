<style> 
    #search_field {
    margin-right:0;
    background: transparent;
    height:40px;
    width: 90%;
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
    }

    #search_button {
        position:absolute;
        top:0;
        right:0;
        width:15%;
        height:40px;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }
    input:focus {
        outline: none !important;
    }
</style> 
<div class="container">
    <div class="column mt-5">
        <div class='row'>
            <div class="col-md-12">
                <form class="form-a" method="GET" action="search.php">
                    <div class="row mt-2">
                        <div class="col-md-11 mx-auto">
                            <div class="form-group" id="search_wrapper">
                                <input type="text" id="search_field" name="equity" class="form-control form-control-lg form-control-a" placeholder="What is your equity?">
                                <button type="submit" id="search_button" name="searchProperty" class="btn btn-b-n" id='searchBtn'><span class="fa fa-search" aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>