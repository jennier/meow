@extends('layouts.master')

@section('title', 'Create Survey')

@section('content')

{!! Form::open(['method' => 'POST', 'route' => array('surveys.store'), 'class' => 'form', 'id' => 'surveyForm']) !!}
<div class="form-group">
    {!! Form::label('name','Name', ['class' => 'control-label']) !!}
    {!! Form::text('name','', ['class' => 'form-control', 'placeholder' => 'Awesome survey is awesome']) !!}
 </div>

 <div class="form-group">
 {!! Form::label('text','Brief Description',array('class' => 'control-label')) !!}
 {!! Form::textarea('text', $value = 'Write something quick about your survey here.', ['class' => 'form-control', 'rows' => '5', 'columns' => '20']) !!}
 </div>
 
 <div class="form-horizontal">
     <div class="form-group">
     
     <!-- At this point we want to introduce the sections "How many seperate sections does your survey contain?" -->
         <label class="col-xs-2 control-label">How many seperate sections does your survey contain?</label>
         <div class="col-xs-5">
     
     	</div>
	 </div>
 </div>
 <div class="form-horizontal">
 <div class="form-group">
 
    <label class="col-xs-2 control-label">Question(s) proposed:</label>
        <div class="col-xs-5">
            {!! Form::text('question[0].name','', ['class' => 'form-control', 'placeholder' => 'Do you want to do what this survey says or what?']) !!}
            
        </div>
        <div class="col-xs-2">
        <select class="form-control option-select" name="question[0].type" id="0">
              <option value="0">Yes or no</option>
              <option value="1">Likert scale (1-5)</option>
              <option value="2">Multiple option</option>
            </select>
        </div>
        <div class="col-xs-2">
            <button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
        </div>
       
</div>

    <!-- The option field template containing an option field and a Remove button -->
    <div class="form-group hide" id="optionTemplate">
        <div class="col-xs-offset-2 col-xs-5">
        	 {!! Form::text('question-name','', ['class' => 'form-control', 'placeholder' => 'Another great question.']) !!}
        </div>
        <div class="col-xs-2">
        <select class="form-control option-select" name="question-type" id="index">
              <option value="0">Yes or no</option>
              <option value="1">1-5 scale</option>
              <option value="2">Multiple options</option>
              <option value="2">Text</option>
            </select>
        </div>
        <div class="col-xs-2">
            <button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button>
        </div>
    </div>
    
    <div class="form group">
    	 <p class="help-block">If your survey has multiple issues, each one be voted on seperately by including multiple questions.</p><p></p>
    </div>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email-modal" id="createButtom">Create</button>
   
 </div>
 
  <div class="modal fade" tabindex="-1" role="dialog" id="email-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Almost done!</h4>
      </div>
      <div class="modal-body">
        <p>Just write a quick email to everyone about your survey so they know to go vote on it.</p>
        <div class="form group">
        	<p>Dear Cats,</p>
        	 {!! Form::textarea('email', $value = 'Hi there! Here\'s some important information about this survey so that you know to go vote on it.', ['class' => 'form-control', 'rows' => '5', 'columns' => '20']) !!}
        </div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		{!! Form::submit('Send email', ['class' => 'btn btn-primary', 'id' => 'emailButton']) !!}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="multi-choice" tabindex="-1" role="dialog" aria-labelledby="multi-choice">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Options</h4>
      </div>
      
      <div class="modal-body">
      	  <div class="form-group row">
              <label class="col-xs-2 control-label">Choices:</label>
              <div class="col-xs-5">
                    {!! Form::text('question[0].choice[]','', ['class' => 'form-control', 'placeholder' => 'Option 1']) !!}
              </div>
              <div class="col-xs-4">
                    <button type="button" class="btn btn-default addChoiceButton"><i class="glyphicon glyphicon-plus"></i></button>
              </div>
          </div>
           
       
          <div class="form-group hide row" id="multiChoiceOpt">
            <div class="col-xs-offset-2 col-xs-5">
                 {!! Form::text('choice','', ['class' => 'form-control', 'id' => 'choice', 'placeholder' => 'Option']) !!}
            </div>
            <div class="col-xs-4">
                <button type="button" class="btn btn-default removeChoiceButton"><i class="glyphicon glyphicon-minus"></i></button>
            </div>
          </div>
          
          <div id="question-id" class="hidden">0</div>
    </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="save-choices">Save choices</button>
      </div>
    </div>
  </div>
</div>

{!! Form::close() !!}

@endsection

@section('jquery')
<script>
$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 5;
	var 	questionIndex = 0;
	var choiceIndex = 0;
	
    $('#surveyForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'question[]': {
                    validators: {
                        notEmpty: {
                            message: 'Ask a question please!'
                        }
                    }
                },
                'option[]': {
                    validators: {
                        notEmpty: {
                            message: 'The option required and cannot be empty'
                        },
                        stringLength: {
                            max: 100,
                            message: 'The option must be less than 100 characters long'
                        }
                    }
                },
				name: {
                    validators: {
                        notEmpty: {
                            message: 'Your survey needs a name.'
                        }
                    }
                }
            }
        })
		
		//On modal open
		.on('click', '.option-select', function() {
			var questionId = event.target.id;
	
			if($(event.target).val() == 2){
				var question = $('[name="question[' + questionId + '].name"]').val();
				var modal = $('#multi-choice').modal();
				
				modal.find('#question-id').text(questionId);
				modal.find('.modal-title').text(question);
				
				$('#multi-choice').modal('show');
			}
	
		})
		
		//On modal close
		$('#multi-choice').on('hide.bs.modal', function () { 
			//For each option we need to replace all the hidden fields
			alert($('#choices').get());
		})
	
        // Add button click handler
        .on('click', '.addButton', function() {
			questionIndex++;
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
								.attr('question-index', questionIndex)
                                .insertBefore($template);
				
			// Update the name attributes
            $clone
                .find('[name="question-name"]').attr('name', 'question[' + questionIndex + '].name').end()
                .find('[name="question-type"]').attr('name', 'question[' + questionIndex + '].type').end()
				.find('[id="index"]').attr('id', questionIndex).end()

       })

        // Remove button click handler
        .on('click', '.removeButton', function() {
			questionIndex--;
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="option[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#surveyForm').formValidation('removeField', $option);
        })

     
		
		 // Add button click handler
        .on('click', '.addChoiceButton', function() {
			choiceIndex++;
			var questionId = $('#question-id').text();
            var $template = $('#multiChoiceOpt'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template);
								
			// Update the name attributes
            $clone
                .find('[name="choice"]').attr('name', 'question[' + questionId + '].choice[]').end()
				.find('[placeholder="Option"]').attr('placeholder', 'Option '. choiceIndex).end()
				.find('[id="choice"]').attr('id', choiceIndex).end()

			$('<input type="hidden" />')
					.attr('name', 'question[' + questionId + '].choice['+ choiceIndex +']')
					.attr('value', '')
					.attr('id', 'choices[]')
					.appendTo('#surveyForm');
         })

        // Remove button click handler
        .on('click', '.removeChoiceButton', function() {
			choiceIndex--;
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="option[]"]');
			
			// Remove hidden fields
			
            // Remove element containing the option
            $row.remove();
        })

	

});
</script>
@endsection

- create one hidden field per option