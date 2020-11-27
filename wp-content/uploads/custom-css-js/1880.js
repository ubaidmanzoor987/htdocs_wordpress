<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
/* Default comment here */ 
 
var show_next = 0;

function setVisibilitytoAll (s, visibility){
  for (var i=0 ; i<s.length ; i++){
    s[i].style.display = visibility;
  }
}
function show_all(event){
  document.getElementsByClassName('list_sel')[0].style.color = "white";
  document.getElementsByClassName('student_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('residential_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('map_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('other_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('hotel_sel')[0].style.color = "#8b734b";
  setVisibilitytoAll(document.getElementsByClassName('student'),"block");
  setVisibilitytoAll(document.getElementsByClassName('hotel'),"block");
  setVisibilitytoAll(document.getElementsByClassName('other'),"block");
  setVisibilitytoAll(document.getElementsByClassName('residential'),"block");
  event.preventDefault();
}

function show_student(event){
  document.getElementsByClassName('student_sel')[0].style.color = "white";
  document.getElementsByClassName('list_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('residential_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('map_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('other_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('hotel_sel')[0].style.color = "#8b734b";
  setVisibilitytoAll(document.getElementsByClassName('student'),"block");
  setVisibilitytoAll(document.getElementsByClassName('hotel'),"none");
  setVisibilitytoAll(document.getElementsByClassName('other'),"none");
  setVisibilitytoAll(document.getElementsByClassName('residential'),"none");
  event.preventDefault();
}
function show_hotel(event){
  document.getElementsByClassName('student_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('list_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('residential_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('map_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('other_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('hotel_sel')[0].style.color = "white";
  setVisibilitytoAll(document.getElementsByClassName('student'),"none");
  setVisibilitytoAll(document.getElementsByClassName('hotel'),"block");
  setVisibilitytoAll(document.getElementsByClassName('other'),"none");
  setVisibilitytoAll(document.getElementsByClassName('residential'),"none");
  event.preventDefault();
}
function show_residential(){
   document.getElementsByClassName('student_sel')[0].style.color = "#8b734b";
    document.getElementsByClassName('list_sel')[0].style.color = "#8b734b";
    document.getElementsByClassName('residential_sel')[0].style.color = "white";
    document.getElementsByClassName('map_sel')[0].style.color = "#8b734b";
    document.getElementsByClassName('other_sel')[0].style.color = "#8b734b";
    document.getElementsByClassName('hotel_sel')[0].style.color = "#8b734b";
   setVisibilitytoAll(document.getElementsByClassName('student'),"none");
  setVisibilitytoAll(document.getElementsByClassName('hotel'),"none");
  setVisibilitytoAll(document.getElementsByClassName('other'),"none");
  setVisibilitytoAll(document.getElementsByClassName('residential'),"block");
  event.preventDefault();
}
function show_other(event){
  document.getElementsByClassName('student_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('list_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('residential_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('map_sel')[0].style.color = "#8b734b";
  document.getElementsByClassName('other_sel')[0].style.color = "white";
  document.getElementsByClassName('hotel_sel')[0].style.color = "#8b734b";
  setVisibilitytoAll(document.getElementsByClassName('student'),"none");
  setVisibilitytoAll(document.getElementsByClassName('hotel'),"none");
  setVisibilitytoAll(document.getElementsByClassName('other'),"block");
  setVisibilitytoAll(document.getElementsByClassName('residential'),"none");
  event.preventDefault();
}

function show_prev(event){
  var getintouchmap = document.getElementsByClassName('getintouchmap')[0].style.display;
  if (getintouchmap == "none"){
   document.getElementsByClassName('getintouchmap')[0].style.display = 'block';
    document.getElementsByClassName('getintouchcareer')[0].style.display = 'none';
  }
  else{
    document.getElementsByClassName('getintouchmap')[0].style.display = 'none';
    document.getElementsByClassName('getintouchcareer')[0].style.display = 'block';
  }
  event.preventDefault();
}

function show_nect(event){
  alert("salam");
  event.preventDefault();
}



</script>
<!-- end Simple Custom CSS and JS -->
