(function( $ ) {
	'use strict';

	    // Make rows sortable
	    $('#team-skills-wrapper').sortable({
	        handle: '.handle'
	    });

	    var wrapper = $('#team-skills-wrapper');
	    var count = wrapper.children().length;

	    $('#add-skill').click(function(e){
	        e.preventDefault();
	        var html = '<div class="team-skill-row">';
	        html += '<span class="dashicons dashicons-move handle"></span>';
	        html += '<input type="text" name="team_skills['+count+'][name]" placeholder="Skill Name" />';
	        html += '<input type="number" name="team_skills['+count+'][value]" placeholder="Value (0-100)" min="0" max="100" />';
	        html += '<button class="remove-skill button">Remove</button></div>';
	        wrapper.append(html);
	        count++;
	    });

	    $(document).on('click', '.remove-skill', function(e){
	        e.preventDefault();
	        $(this).parent().remove();
	    });

	    // Add new row
	    $('#addsocialicons').on('click', function(e) {
	        e.preventDefault();
	        var row = $('.emptyicons.screen-reader-text').clone(true);
	        row.removeClass('emptyicons screen-reader-text');
	        row.insertBefore('#repeatable_socialicons .allicolist>.removescicons:last');

	        return false;
	    });

	    // Remove row
	    $(document).on('click', '.removeiconcolumns', function(e) {
	        e.preventDefault();
	        $(this).parents('.removescicons').remove();
	        return false;
	    });

	    // Sortable
	    $('#repeatable_socialicons .allicolist').sortable({
	        opacity: 0.6,
	        revert: true,
	        cursor: 'move',
	        handle: '.sorticonlists'
	    });

})( jQuery );