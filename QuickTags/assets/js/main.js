QTags.addButton('qtsd-button-one', 'U', '<u>', '</u>');
QTags.addButton('qtsd-button-one', 'JS', qtsd_button_two);
QTags.addButton('qtsd-button-three', 'FontAwesome', qtsd_fap_preview);

function qtsd_button_two() {
	let name = prompt('What is your name');
	let text = "Hello " + name;
	QTags.insertContent(text);
}

function qtsd_fap_preview() {
	tb_show('FontAwesome', qtsd.preview);
}

function insertFA(icon) {
	tb_remove();
	QTags.insertContent('<i class="fa ' + icon + '"></i>');
}