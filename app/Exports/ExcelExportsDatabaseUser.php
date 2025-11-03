<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExcelExportsDatabaseUser implements FromArray,WithHeadings
{
    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    private $start;
    private $end;
    private $typeUser;
    public function __construct($start,$end,$typeUser)
    {
        $this->start=$start;
        $this->end=$end;
        $this->typeUser=$typeUser;
        $nameModel ='\App\Models\User';
        $this->model= new $nameModel;
        $this->selectField="*";
        $this->title=true;
       // $this->typeUser=config('');
        $this->titleField= [
            "order" => "STT",
            "username"=>  "Username",
            "name" => "Họ tên",
            "phone"=> "Số điện thoại",
            "address" => "Địa chỉ",
            "date_birth" => "Ngày sinh",
            "hktt" => "HKTT",
            "cmt" => "CMT",
            "stk" =>  "STK",
            "ctk" =>  "CTK",
            "bank" =>  "Tên ngân hàng",
            "bank_branch" =>  "Chi nhánh ngân hàng",
            "sex" =>  "Giới tính",
            "active" =>  "Trạng thái",
            'parent_id'=>"Người giới thiệu",
            'admin_id'=> 'Admin xử lý',
            'created_at'=>"Ngày kích hoạt",
        ];
    }

    public function array(): array
    {
        $data=[];
       // dd($this->start,$this->end);
       if($this->typeUser==-1){
        $user=$this->model->whereBetween('created_at',[$this->start,$this->end])->select($this->selectField)->get();
       }else{
        $user=$this->model->whereBetween('created_at',[$this->start,$this->end])->where('active',$this->typeUser)->select($this->selectField)->get();
       }
      // dd($user);
       if($user->count()>0){
        foreach ($user as $value) {
         //   dd(date_format($value->created_at,'d/m/Y'));
            $item=[];
            $item['order']=$value->order?$value->order:"chưa cập nhập";
            $item['username']=$value->username?$value->username:'Chưa cập nhập';
            $item['name']=$value->name?$value->name:'Chưa cập nhập';
            $item['phone']=$value->phone?$value->phone:'Chưa cập nhập';
            $item['address']=$value->address?$value->address:'Chưa cập nhập';
            $item['date_birth']=$value->date_birth?$value->date_birth:'Chưa cập nhập';
            $item['hktt']=$value->hktt?$value->hktt:'Chưa cập nhập';
            $item['cmt']=$value->cmt?$value->cmt:'Chưa cập nhập';
            $item['stk']=$value->stk?$value->stk:'Chưa cập nhập';
            $item['ctk']=$value->ctk?$value->ctk:'Chưa cập nhập';

            $item['bank']=$value->bank_id?$value->bank->name:'Chưa cập nhập';
            $item['bank_branch']=$value->bank_branch?$value->bank_branch:'Chưa cập nhập';
            $item['sex']=$value->sex==1?"Name":($value->sex===0?"Nữ":'Chưa cập nhập');
            $item['active']=$value->active==1?"Active":($value->active==0?"Disable":($value->active==2?'Khóa':''));
            $item['parent_id']=$value->parent_id==0?"":($value->parent->username);
            $item['admin_id']=$value->admin_id==0?"":($value->admin->email);
            $item['created_at']=date_format($value->created_at,'d/m/Y');
            array_push($data,$item);
        }
       }

      //  dd($data);
        return $data;
    }
    // add title for file export
     public function headings(): array
     {
         if($this->title){
             return $this->titleField;
         }
         else{
             return [];
         }
     }
}
