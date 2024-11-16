<?php
include('connection.php');
$query = "SELECT * FROM etudiant";
$result = mysqli_query($connection, $query);


while ($row = mysqli_fetch_assoc($result)) {
  /*echo "<div class =\"tableFixHead\">"
  ."<table>"
  ."<thead>"
  ."<tr>"."<th>Numero Apogee</th>".
  "<th>nom</th>".
  "<th>prenom</th>".
  "<th>e-mail</th>".
  "<th>telephone</th>".
  "<th>dateDeNaisssance</th>"
  ."</tr>"
  ."<tbody>"
  ."<tr>".
  "<td>".$row['Apogee']."</td>".
  "<td>".$row['nom']."</td>".
  "<td>".$row['prenom']."</td>".
  "<td>".$row['e-mail']."</td>".
  "<td>".$row['telephone']."</td>".
  "<td>".$row['dateDeNaisssance']."</td>"
  ."</tr>"
  ."</tbody>"
  ."</thead>"
  ."</table>"
  ."</div>" ;*/

  echo "<tr>" . 
         "<td>" . $row['Apogee'] . "</td>" .
         "<td>" . $row['nom'] . "</td>" .
         "<td>" . $row['prenom'] . "</td>" .
         "<td>" . $row['email'] . "</td>" .
         "<td>" . $row['telephone'] . "</td>" .
         "<td>" . $row['dateDeNaisssance'] . "</td>" .
         "<td>
            <div id='btn'>
              <form action='delete_update_User.php' method='POST'>
                <button type='submit' name='delete' value='".$row['Apogee']."'><i class='bx bx-trash'></i></button>
                <button type='submit' name='update' value='".$row['Apogee']."'><i class='bx bx-edit-alt'></i></button>
              </form>
            </div>
          </td>" .
       "</tr>";
    
}


?>