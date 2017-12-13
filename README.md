# CSC468 Programming Assignment #2: CSC Major Checklist

## Assignment

Filling out the CSC requirements checklist by hand is a somewhat tedious and 
error-prone task. This Web app gives students a way to log in, complete the 
checklist form online and store their progress. It also doubles as an advising 
tool by color coding courses completed, eligible courses, and courses that still
lack prerequisites. 

Student information will be stored in XML format on the MCS Web server, using 
the student ID as a file name (studentID.xml). Course information (including 
course prerequisites and offerings) will be stored in XML format on the server, 
in a file named courses.xml. Based on information in the student file, current 
course offerings, and course prerequisites, the program suggests courses for the
student to register in. 

## TODO 

 - ~~Log-in page~~
    - ~~Store student info (studentID.xml)~~
 - Color-coded course checklist with student info. (name, ID, courses completed,
   grades, GPA, overall progress towards degree, etc.)
 - ~~Define XML tags for storing student data for this application. Provide a 
   DTD (studentinfo.dtd) for these.~~
 - Allow updates to courses  completed (with grades), courses in progress, etc.
 - On grade change:
    - Recalculate courses completed, GPA, overall progress towards degree. 
    - PreRekCheking - Color in courses (green, yellow, red). Create alert if 
      student doesn't have a prereq (suggest filling in 'EX'). Revert grade 
      change.
 - Save button - php script to write out student data to xml
 - Come up with heuristic for advising recommendations. (refer to notes in 
   program write-up)
 - Flag errors
    - Credits > 120 (soft warning)
 - ~~Store the server-side files in the document root of your server.~~
 - Provide sample student files for testing.
 - ~~Project must run on department web server and be named CS_checklist.html~~

*Note: Strikethrough using two tildes. `~~Scratch this.~~` = ~~Scratch this.~~

## References and Resources

http://www.mcs.sdsmt.edu/csc468/Assignments/PA2/PA2.pdf

http://www.mcs.sdsmt.edu/csc468/Code/Web/

http://www.mcs.sdsmt.edu/csc468/Resources/Web/

https://docs.gitlab.com/ee/user/markdown.html