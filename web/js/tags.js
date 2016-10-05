$( document ).ready(function() {


$('.add_tag').click(function() {
	var feedbackformText = document.getElementById('feedbacks-text');
  	var startPos = feedbackformText.selectionStart;
    var endPos = feedbackformText.selectionEnd;
    var start = selectedText = feedbackformText.value.substring(0, startPos);
    var selected = selectedText = feedbackformText.value.substring(startPos, endPos);
    var end = selectedText = feedbackformText.value.substring(endPos);
    var tag = this.getAttribute("data-parameter");
    var input_tag = (tag == 'a')?'a href="" title=""':tag;
    feedbackformText.value=start+'<'+input_tag+'>'+selected+'</'+tag+'>'+end;
    return false;
})

$('.show_preview').click(function() {
	var feedbackformText = document.getElementById('feedbacks-text');
	var preview = document.getElementById('preview');
	preview.innerHTML = feedbackformText.value.replace(/\n/g, '<br>');
	$('#preview').css('display', 'inherit');
    return false;
})


});