@extends('layouts.master')

@section('title', 'Create Ballot')

@section('content')

{!! Form::open(['method' => 'POST', 'route' => array('ballots.store'), 'class' => 'form', 'id' => 'surveyForm']) !!}
<div class="form-group">
    {!! Form::label('name','Name', ['class' => 'control-label']) !!}
    {!! Form::text('name','', ['class' => 'form-control', 'placeholder' => 'Awesome ballot is awesome']) !!}
 </div>
@if(Entrust::hasRole('hr'))
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">HR Related Stuff</h3>
  </div>
  <div class="panel-body">
    <h5>Ballot Type</h5>
    <p>Is this a ballot about membership in some way? If so, please check 'private' - this will make it so only the user's vote is visible to them, and make the ballot live immediately with no need for support.</p>
     <div class="radio">
     <label>
        <input type="radio" name="type" id="type" value="0" checked>
         Public 
     </label>
     </div>
     <div class="radio">
     <label>
        <input type="radio" name="type" id="type" value="1">
         Private
     </label>
     </div>
    </div>
 </div>
 
 @else 
  <input type="hidden" name="type" value="0">
 @endif
 <div class="form-group">
 {!! Form::label('text','Brief Description',array('class' => 'control-label')) !!}
 {!! Form::textarea('text', $value = 'Write something quick about your ballot here.', ['class' => 'form-control', 'rows' => '5', 'columns' => '20']) !!}
 </div>
 <div class="form-group">
  {!! Form::label('link','URL to extra documents',array('class' => 'control-label')) !!}
  {!! Form::text('link','', ['class' => 'form-control', 'placeholder' => 'http://']) !!}
   <p class="help-block">If you have additional information in a Google Doc or a full proposal, link to it here. Not required but v helpful.</p>
 </div>
 
 <div class="form-horizontal">
 <div class="form-group">
    <label class="col-xs-2 control-label">Question(s) proposed:</label>
        <div class="col-xs-5">
            {!! Form::text('question[0][name]','', ['class' => 'form-control', 'placeholder' => 'Do you want to do what this ballot says or what?']) !!}
            
        </div>
        <div class="col-xs-2">
        <select class="form-control option-select" name="question[0][type]" id="0">
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
              <option value="1">Likert scale (1-5)</option>
              <option value="2">Multiple option</option>
            </select>
        </div>
        <div class="col-xs-2">
            <button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button>
        </div>
    </div>
    
    <div class="form group">
    	 <p class="help-block">If your ballot has multiple issues, each one be voted on seperately by including multiple questions.</p><p></p>
    </div>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email-modal" id="createButtom">Create</button>
   
 </div>
 
 <!-- Email modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="email-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Almost done!</h4>
      </div>
      <div class="modal-body">
        <p>Just write a quick email to everyone about your ballot so they know to go vote on it.</p>
        <div class="form group">
        	<p>Dear Cats,</p>
        	 {!! Form::textarea('email', $value = 'Hi there! Here\'s some important information about this ballot so that you know to go vote on it.', ['class' => 'form-control', 'rows' => '5', 'columns' => '20']) !!}
        </div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		{!! Form::submit('Send email', ['class' => 'btn btn-primary', 'id' => 'emailButton']) !!}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                            message: 'Your ballot needs a name.'
                        }
                    }
                }
            }
        })
		
		//On modal open
		.on('click', '.option-select', function() {
			var questionId = event.target.id;
			var customModal = $('<div class="modal fade" id="multi-choice' + questionId + '" tabindex="-1" role="dialog" aria-labelledby="multi-choice"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="myModalLabel">Create Options</h4> </div> <div class="modal-body" id="' + questionId + '"> <div class="form-group row"> <label class="col-xs-2 control-label">Choices:</label> <div class="col-xs-5"> <input type="text" name="question[' + questionId + '][choice][]" class="form-control" placeholder="Option 1"> </div><div class="col-xs-4"> <button type="button" class="btn btn-default addChoiceButton"><i class="glyphicon glyphicon-plus"></i></button> </div> </div><div id="question-id" class="hidden">' + questionId + '</div><div class="form-group hide row" id="multiChoiceOpt' + questionId + '"><div class="col-xs-offset-2 col-xs-5"><input type="text" name="choice" class="form-control" id="choice" placeholder="Option"></div><div class="col-xs-4"><button type="button" class="btn btn-default removeChoiceButton"><i class="glyphicon glyphicon-minus"></i></button></div></div><div id="question-id" class="hidden">' + questionId + '</div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" data-dismiss="modal" id="save-choices">Save choices</button></div></div></div></div>');
			if($(event.target).val() == 2){
				if($('#multi-choice'+ questionId).length < 1){
					$('#surveyForm').append(customModal);
				}
				$('#multi-choice'+ questionId).modal('show');
			}
			/*
			if($(event.target).val() == 2){
				var question = $('[name="question[' + questionId + '].name"]').val();
				var modal = $('#multi-choice').modal();
				
				modal.find('#question-id').text(questionId);
				modal.find('.modal-title').text(question);
				
				$('#multi-choice').modal('show');
			}
			*/
	
		})
		
		//On modal close
		//$('#multi-choice').on('hide.bs.modal', function () { 
			//For each option we need to replace all the hidden fields
			//alert($('#choices').get());
		//})
	
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
                .find('[name="question-name"]').attr('name', 'question[' + questionIndex + '][name]').end()
                .find('[name="question-type"]').attr('name', 'question[' + questionIndex + '][type]').end()
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
			var questionId = $(this).parents('.modal-body').attr("id"); ///
            var $template = $('#multiChoiceOpt' + questionId),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template);
								
			// Update the name attributes
            $clone
                .find('[name="choice"]').attr('name', 'question[' + questionId + '][choice][]').end()
				.find('[placeholder="Option"]').attr('placeholder', 'Option '. choiceIndex).end()
				.find('[id="choice"]').attr('id', choiceIndex).end()

			//$('<input type="hidden" />')
				//	.attr('name', 'question[' + questionId + '].choice['+ choiceIndex +']')
				//	.attr('value', '')
				//	.attr('id', 'choices[]')
				//	.appendTo('#surveyForm');
         })

        // Remove button click handler
        .on('click', '.removeChoiceButton', function() {
			choiceIndex--;
			var questionId = $('#question-id').text();
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="question[' + questionId + '].choices['+ choiceIndex +']"]');
			 
            // Remove element containing the option
            $row.remove();
        })

	

});
</script>
@endsection
