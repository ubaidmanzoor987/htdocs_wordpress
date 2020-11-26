<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
/* Default comment here */ 

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


</script>
<!-- end Simple Custom CSS and JS -->
