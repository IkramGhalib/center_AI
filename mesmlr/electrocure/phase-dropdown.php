<?php

$phase = $_POST['phaseid'];
//$phase =1;
if ($phase == '1' )
{
  echo "<div class = 'form-group row'>

			<label class='col-sm-2 col-form-label'>Phase 1 kwh peak</label>

                <div class='col-sm-6'>

					<input type='textarea' class='form-control' name = 'pk1' placeholder = 'Type Off Peak' required = 'required' />

				</div>
                                    
		</div>";
    
     echo "<div class = 'form-group row'>

			<label class='col-sm-2 col-form-label'>Phase 1 kwh offpeak</label>

                <div class='col-sm-6'>

					<input type='textarea' class='form-control' name = 'offpk1' placeholder = 'Type Off Peak' required = 'required' />

				</div>
                                    
		</div>";

}
elseif($phase =='2')
{
     echo "<div class = 'form-group row'>

			<label class='col-sm-2 col-form-label'>Phase 1 kwh peak</label>

                <div class='col-sm-6'>

					<input type='textarea' class='form-control' name = 'pk2'placeholder = 'Type Off Peak' required = 'required' />

				</div>
                                    
		</div>";
    
     echo "<div class = 'form-group row'>

			<label class='col-sm-2 col-form-label'>Phase 1 kwh offpeak</label>

                <div class='col-sm-6'>

					<input type='textarea' class='form-control' name = 'offpk2' placeholder = 'Type Off Peak' required = 'required' />

				</div>
                                    
		</div>";
    
}

?>