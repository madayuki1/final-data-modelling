
<?php 
#fungsi
$db=mysqli_connect("localhost","root","","final-pemodelan");

function query($query){
    global $db;
    $result =mysqli_query($db,$query);
    $rows =[];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[]=$row;
    };
    return $rows;
}

function tambah($data){
    
        global $db;
        $nrp=htmlspecialchars($data["nrp"]);
        $nama=htmlspecialchars($data["nama"]);
        $email=htmlspecialchars($data["email"]);
        $jurusan=htmlspecialchars($data["jurusan"]);
        //$gambar=htmlspecialchars($data["gambar"]);

        $gambar = uploud();
        if(!$gambar){
            return false;
        }
        
        $query="INSERT INTO mahasiswa
         VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";
         mysqli_query($db,$query);
         return(mysqli_affected_rows($db));
   
}
function uploud(){

    $nama_file=$_FILES['gambar']['name'];
    $ukuran_file=$_FILES['gambar']['size'];
    $error=$_FILES['gambar']['error'];
    $tmp_name=$_FILES['gambar']['tmp_name'];

    // cek aapakah tidak ada gambar yang di uploud

    if($error === 4){
        echo "<script>
        alert('pilih gambar terlebih dahulu')
        </script>";
        return false;
    }
    $ekstensiGambarValid=['jpg','jpeg','png'];
    $ekstensi_gambar = explode('.',$nama_file);//delimiter nya adalah titik sehingga bkan memisahkan file menjadi
                                                //array yang berbeda jika melewati titik
    $ekstensi_gambar=strtolower(end($ekstensi_gambar));
    if(!in_array($ekstensi_gambar,$ekstensiGambarValid))
    {
        echo "<script>
        alert('bukan gambar ini mah')
        </script>
        ";
        return false; 
    };
    if( $ukuran_file > 1000000){ // dalam byte (ukuran file di batasi 1 mb)
        echo "<script>
            alert('ukuran kebesaran bro')
            </script>";
            return false;
    }

    //gambar siap di uploud nih 
    //(problem) bila user memiliki foto dengan nama file yang sama , maka 
    //foto yang sebelumnya akan tertimpa dan terganti dengan foto yang baru :( 
    //so solusinyaa ->
    $namaFileBaru=uniqid();
    $namaFileBaru .='.'.$ekstensi_gambar;


    move_uploaded_file($tmp_name,'image/'.$namaFileBaru) ;//jadi sebenrnya ketika uploud img file kita itu di simpan di tmp directory 
                                                    //sehingga kita perlu memindahkan ke folder yang kamu mau cuy
    return $namaFileBaru;                                        
    
}
function hapus($id){
    global $db;
    mysqli_query($db,"DELETE FROM mahasiswa WHERE id=$id");
    return(mysqli_affected_rows($db));
}
function ubah($id,$data){
    global $db;
    print_r($data);
    $nrp=htmlspecialchars($data["nrp"]);
    $nama=htmlspecialchars($data["nama"]);
    $email=htmlspecialchars($data["email"]);
    $jurusan=htmlspecialchars($data["jurusan"]);
    $gambarLama=htmlspecialchars($data["gambarLama"]);
    
    //cek dulu user uploud gambar yang baru gk bro
    if($_FILES['gambar']['error']===4){
        $gambar=$gambarLama;

    }
    else{
        $gambar=uploud();
    }
    // $query="INSERT INTO mahasiswa
    //  VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";
    $query="UPDATE mahasiswa SET 
                nrp     ='$nrp',
                nama    ='$nama',
                email   ='$email',
                jurusan ='$jurusan',
                gambar  ='$gambar'
                where id=$id
                " ;

    mysqli_query($db,$query);
    return(mysqli_affected_rows($db));
}

function cari($keyword){
    //print($keyword);
     $query="SELECT * FROM movies
     WHERE 
     movie_name LIKE '%$keyword%' OR
     genre LIKE '%$keyword%' OR
     studio_id LIKE '%$keyword%' OR
     release_date LIKE '%$keyword%' 
            ";
     return query($query);
}

function registrasi($data){
    global $db;
    $username=strtolower(stripslashes($data["username"]));
    $password=mysqli_real_escape_string($db,$data["password"]);
    $password2=mysqli_real_escape_string($db,$data["password2"]);

    //username udah ada atau belum
    $checkuser=mysqli_query($db,"SELECT username from users where username='$username'");
    if(mysqli_fetch_assoc($checkuser)){
        echo "<script>
        alert('username sudah terdaftar')</script>";
        return false;
    }
    //cek confirmasi password 
    if($password!==$password2){
    echo "<script>
    alert('password tidak sesuai');
    </script>";
    return false;
    }
    //enkripsi password dulu bossqu
    $password=password_hash($password,PASSWORD_DEFAULT);
    //masukan ke database
    
    mysqli_query($db,"INSERT INTO users VALUE ('','$username','$password')");
    return mysqli_affected_rows($db); 
}
?>