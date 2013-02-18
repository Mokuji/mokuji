//Only if jQuery is present.
if(window.$) $(function(){

  // Add pdf icons to pdf links.
  $("a[href$='.pdf']").addClass("pdf");
   
  // Add txt icons to document links (doc, rtf, txt).
  $("a[href$='.doc'], a[href$='.txt'], a[href$='.rft']").addClass("txt");

  // Add zip icons to Zip file links (zip, rar).
  $("a[href$='.zip'], a[href$='.rar']").addClass("zip"); 
  
  // Add image icons to Image file links (jpg, png).
  $("a[href$='.jpg'], a[href$='.png']").addClass("img"); 
  
  // Add email icons to email links.
  $("a[href^='mailto:']").addClass("email");

  //Add external link icon to external links.
  $('a[target="_blank"]').addClass("external");  

});
