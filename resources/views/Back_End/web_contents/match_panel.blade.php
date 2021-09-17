@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">新增媒合表現設定</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;">媒合表現設定</h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="new_match_performance" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="vb/d2Zqgrik1mfI3GWN1GDyUdlQxPmn0qhBggwP3VccaAeDilJQJ2jcHSaJ0cpQceYZuXux4LghkaPDsg7nJDA==" />
                    @csrf
                    <div class="advantage_wrapper">
                    <div class="advantage_area">
                        <div class="advantage_row clearAfter col-xs-12 m-b-15 no-padding">
                        <div class="col-md-4 col-xs-12">
                            <div class="advantage_block">
                            <div class="match_performance_img"><img class="match_img" src="/assets/match-3.png" alt="User income" /></div>
                            <div class="advantage_block_title m-b-5">
                                會員收益
                            </div>
                            <div class="advantage_block_content">
                                
                            <input class="numeric integer required form-control width_eighty" value='{{ number_format($memberBenefits) }}' min="0" type="number" step="1" name="memberBenefits" id="memberBenefits" />元
                               
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="advantage_block">
                            <div class="match_performance_img"><img class="match_img" src="/assets/match-2.png" alt="Invest amount" /></div>
                            <div class="advantage_block_title m-b-5">
                                投資總額
                            </div>
                            <div class="advantage_block_content">
                                <input class="numeric integer required form-control width_eighty" value='{{ number_format($totalInvestAmount) }}' min="0" type="number" step="1" name="totalInvestAmount" id="totalInvestAmount" />元
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="advantage_block">
                            <div class="match_performance_img"><img class="match_img" src="/assets/match-1.png" alt="Annual avg" /></div>
                            <div class="advantage_block_title m-b-5">
                                年平均報酬
                            </div>
                            <div class="advantage_block_content">
                                <input class="numeric float required form-control width_eighty" value='{{ number_format($annualBenefitsRate,2) }}' min="0" type="number" step="any" name="annualBenefitsRate" id="annualBenefitsRate" /> %
                          
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-12">
                        <button type="button" onclick="update_item();" class="btn btn-info pull-right m-r-5">儲存</button>
                        
                        </div>
                    
                    </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

      </section>
    </section>

</section>

    <script>

        function update_item(){
            $.ajax({
            type:"POST",
            url:"/match_performances/new",
            dataType:"json",
            data:
                $('#new_match_performance').serialize()
            ,
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.reload();
                }
            }
        });
    }
                


        
    </script>

@endsection             