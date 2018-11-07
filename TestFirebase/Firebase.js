// Initialize Firebase
var config = {
	apiKey: "",
	authDomain: "",
	databaseURL: "",
	projectId: "",
	storageBucket: "",
	messagingSenderId: ""
};

firebase.initializeApp(config);

// Define database reference head for data "Users"
var firebaseRef = firebase.database();
//firebase.database().ref('Users/');
var usersRef = firebaseRef.ref('Users/');

var tableUsers = document.getElementById('tableUsersList');
var rowIndex = 1;

// database.ref().once -- changes once and then stops
// database.ref().on -- keeps listening for changes
usersRef.on("value", function(snapshot) {
	
	if(snapshot.exists()) {
		var content = '';
		snapshot.forEach(function(childSnapshot) { 
		
			var user_name = childSnapshot.val().Name;
			var matrics_no = childSnapshot.key;
			var user_course = childSnapshot.val().Course;
			
			var row = tableUsers.insertRow(rowIndex);
			var col1 = row.insertCell(0);
			var col2 = row.insertCell(1);
			var col3 = row.insertCell(2);
			var col4 = row.insertCell(3);
			
			col1.appendChild(document.createTextNode(rowIndex));
			col2.appendChild(document.createTextNode(user_name));
			col3.appendChild(document.createTextNode(matrics_no));
			col4.appendChild(document.createTextNode(user_course));
			
			rowIndex = rowIndex + 1;
		});
	}
});
 
function save_user() {
	var user_name = document.getElementById('user_name').value;
	var matrics_no = document.getElementById('matrics_no').value;
	var user_course = document.getElementById('user_course').value;
	
	if(user_name.trim() == '' || matrics_no.trim() == '' || user_course.trim() == '') {
		alert("Incomplete Information");
		return false;
	}
	
	// Set variable reference name in Firebase
	var data = {
		Name: user_name,
		Matrics: matrics_no,
		Course: user_course
	}
 
	var updates = {};
	// Define Primary Key set as Root of data
	updates['/Users/' + matrics_no] = data;
	firebase.database().ref().update(updates);
 
	alert('The user is created successfully!');
	reload_table();
}

function update_user() {
	var user_name = document.getElementById('user_name').value;
	var matrics_no = document.getElementById('matrics_no').value;
	var user_course = document.getElementById('user_course').value;

	var data = {
			Name: user_name,
			Matrics: matrics_no,
			Course: user_course
	}
 
	var updates = {};
	updates['/Users/' + matrics_no] = data;
	firebase.database().ref().update(updates);
 
	alert('The user is updated successfully!');
 
	reload_table();
}

function delete_user() {
	var matrics_no = document.getElementById('matrics_no').value;

	firebase.database().ref().child('/Users/' + matrics_no).remove();
	alert('The user is deleted successfully!');
	reload_table();
}

function reload_table() {
	window.location.reload();
}
