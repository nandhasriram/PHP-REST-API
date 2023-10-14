<?php

require '../inc/dbcon.php';

function error422($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP/1.0 422 Unprocess Entity");
    echo json_encode($data);
    exit();
}
function officeEmployee($employeeInput){
    global $conn;
    $name=mysqli_real_escape_string($conn,$employeeInput['name']);
    $email=mysqli_real_escape_string($conn,$employeeInput['email']);
    $phone=mysqli_real_escape_string($conn,$employeeInput['phone']);

    if(empty(trim($name))){
        return error422('Enter Your Name');
    }elseif(empty(trim($email))){
        return error422('Enter Your email');
    }elseif(empty(trim($phone))){
        return error422('Enter Your phone');
    }
    else{
        $query="INSERT INTO employees(name,email,phone) VALUES('$name','$email','$phone')";
        $result=mysqli_query($conn,$query);

        if($result){
            $data=[
            'status'=>201,
            'message'=>'Employee Created Successfully',
    ];
    header("HTTP/1.0 201 Created");
    return json_encode($data);

        }else{
           $data=[
            'status'=>500,
            'message'=>'Internal Server Error',
    ];
    header("HTTP/1.0 500 Method Not Allowed");
    return json_encode($data); 
        }
    }
}


function getEmployeeList(){

    global $conn;

    $query="SELECT * FROM employees";
    $query_run=mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){
            $res=mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data=[
                'status'=>200,
                'message'=>'Employee List Fetched Successfully',
                'data'=>$res
    ];
    header("HTTP/1.0 200 Employee List Fetched Successfully");
    return json_encode($data);

        }else{
            $data=[
                'status'=>404,
                'message'=>'No Employee Found',
    ];
    header("HTTP/1.0 404 No Employee Found");
    return json_encode($data);
        }
    }
    else
    {
        $data=[
            'status'=>500,
            'message'=>'Internal Server Error',
    ];
    header("HTTP/1.0 500 Method Not Allowed");
    return json_encode($data);
    }

}
function getEmployee($employeeParams){
    global $conn;

    if($employeeParams['id']==null){
        return error422('Enter Your Employee Id');
    }
    $employeeId=mysqli_real_escape_string($conn,$employeeParams['id']);
    $query="SELECT * FROM employees WHERE id='$employeeId' LIMIT 1";
    $result=mysqli_query($conn,$query);

    if($result){
        if(mysqli_num_rows($result)==1)
        {
            $res=mysqli_fetch_assoc($result);

            $data=[
            'status'=>200,
            'message'=>'Employee Fetched successfully',
            'data'=>$res
    ];
    header("HTTP/1.0 200 Success");
    return json_encode($data);
    }
    else
    {
        $data=[
            'status'=>404,
            'message'=>'No Customer Found',
    ];
    header("HTTP/1.0 404 Not Found");
    return json_encode($data);
    }
    }
}

function updateEmployee($employeeInput, $employeeParams){
    global $conn;
    
    if(!isset($employeeParams['id'])){
        return error422('Employee Id Not Found In URL');
    }
    else if($employeeParams['id']==null){
        return error422('Enter The Employee Id');
    }
    $employeeId=mysqli_real_escape_string($conn,$employeeParams['id']);

    $name=mysqli_real_escape_string($conn,$employeeInput['name']);
    $email=mysqli_real_escape_string($conn,$employeeInput['email']);
    $phone=mysqli_real_escape_string($conn,$employeeInput['phone']);

    if(empty(trim($name))){
        return error422('Enter Your Name');
    }elseif(empty(trim($email))){
        return error422('Enter Your email');
    }elseif(empty(trim($phone))){
        return error422('Enter Your phone');
    }
    else{
        $query="UPDATE employees SET name='$name' , email='$email' , phone='$phone' WHERE id='$employeeId' LIMIT 1";
        $result=mysqli_query($conn,$query);

        if($result){
            $data=[
            'status'=>200,
            'message'=>'Employee Updated Successfully',
    ];
    header("HTTP/1.0 200 Updated");
    return json_encode($data);

        }else{
           $data=[
            'status'=>500,
            'message'=>'Internal Server Error',
    ];
    header("HTTP/1.0 500 Method Not Allowed");
    return json_encode($data); 
        }
    }
}

function deleteEmployee($employeeParams){
    global $conn;
    if(!isset($employeeParams['id'])){
        return error422('Employee Id Not Found In URL');
    }
    else if($employeeParams['id']==null){
        return error422('Enter The Employee Id');
    }
    $employeeId=mysqli_real_escape_string($conn,$employeeParams['id']);

    $query="DELETE FROM employees WHERE id='$employeeId' LIMIT 1";
    $result=mysqli_query($conn,$query);

    if($result){
        $data=[
            'status'=>200,
            'message'=>'Customer Deleted Successfully',
    ];
    header("HTTP/1.0 200 Deleted");
    return json_encode($data);
    }else{
        $data=[
            'status'=>404,
            'message'=>'Employee Not Found',
    ];
    header("HTTP/1.0 404 Not Found");
    return json_encode($data);
    }
}

?>