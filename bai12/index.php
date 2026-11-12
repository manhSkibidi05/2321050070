<h1>Đây là file index.php</h1>

<?php //đây là vị trí code ?>
<?php 
    //in ra màn hình
    echo "Hello World! <br>";

    //biến: $tên biến= giá trị (tên bắt đầu bằng chữ hoặc _ không phải số, phân biệt chữ hoa)
    $hoTen = "Phan Mạnh";
    $tuoi = 19;
    // dấu . để nối chuỗi
    echo $hoTen ." ". $tuoi ."<br>";

    //strlen() độ dài chuỗi (tính cả dấu chữ)
    echo strlen($hoTen)."<br>";

    //đếm số từ (tính cả dấu chữ)
    echo str_word_count($hoTen)."<br>";

    //tìm kiếm kí tự trong chuỗi (báo vị trí)
    echo strpos($hoTen, "ô")."<br>";
    echo strpos($hoTen, "n")."<br>";

    //thay thế kí tự trong chuỗi
    echo str_replace("Mạnh","Chúa",$hoTen)."<br>";

    $soThuNhat=10;
    $soThuHai=5;
    //phép cộng
    echo $soThuNhat + $soThuHai ."<br>";
    //phép trừ
    echo $soThuNhat - $soThuHai ."<br>";
    //phép nhân
    echo $soThuNhat * $soThuHai ."<br>";
    //phép chia
    echo $soThuNhat / $soThuHai ."<br>";
    //chia lấy dư
    echo $soThuNhat % $soThuHai ."<br>";

    //toán tử gán
    // += -= *= /= %=

    //toán tử so sánh
    // == != > < >= <= ===
    //đúng là 1 sai là không

    //câu điều kiện
    // if ("điều kiện"){
    //     logic
    // } elseif ("điều kiện"){
    //     logic 
    // } else {
    //     logic
    // }

    if ($soThuNhat+$soThuHai < 15){
        echo "nhỏ hơn 15";
    } elseif ($soThuNhat+$soThuHai == 15){
        echo "bằng 15";
    } else{
        echo "lớn hơn 15";
    }


    //switch case
    $color = "red";
    switch($color){
        case "red":
            echo "<br>";
            echo "Is RED";
            break;
        case "blue":
            echo "<br>";
            echo "Is BLUE";
            break;
        default:
        echo "<br>";
        echo "no color";
        break;
    }
    echo "<br>";

    //for
    for ($i=0; $i<=100; $i++){
        echo $i ." ";
    }
    echo "<br>";

    //mảng
    $mang = ["Phan", "Mạnh", "Công", "Anh"];
    // đếm phần tử
    echo count ($mang)."<br>";
    echo $mang[2]."<br>";
    echo $mang[3]."<br>";

    //thêm phần tử vào mảng
    $mang[]="Đẹp Trai";

    //in ra toàn bộ mảng
    print_r($mang);

    echo "<br>";
    //bỏ 1 phần tử
    unset($mang[3]);
    print_r($mang);
?>