 <div class="row accTabsInfo order-tale-tabs add-post-table">
   <div class="col-sm-12 col-12 mt-3">
      <div class="sec-title account-heading">
         <h3 style="margin-bottom:15px;" class="font-20 text-black account-title">Dine annonser</h3>
      </div>
      <div class="table-responsive table-data">
         <table class="table table-hover  tbl_res table-responsive">
            <thead>
               <tr class="">
                  <th width="18%">Tittel</th>
                  <th>Beskrivelse</th>
                  <th width="12%">Pris</th>
                  <th width="12%">plassering</th>
                  <th width="12%">Status</th>
                  <th width="12%">Handlinger</th>
               </tr>
            </thead>
            <tbody>
               @foreach($products as $product)
               <tr>
                  <td>{{ $product['product_name'] }}</td>
                  <td>{{ $product['description'] }}</td>
                  <td>{{ $product['product_price'] }} kr</td>
                  <td>{{ $product['city'] }}</td>
                  <td>
                     @if($product['status']==1)
                        Aktiv
                     @else
                        Inaktiv
                     @endif
                  </td>
                  <td>
                     <a href="{{ url('user/edit-product/'.$product['id']) }}"><button class="add-post-btn"><i title="Redigere Annonse" class="fa fa-edit" aria-hidden="true"></i>&nbsp;Redigere</button></a>&nbsp;&nbsp;
                     <a href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{ $product['id'] }}"><button class="add-post-btn"><i title="Slett Annonse" class="fa fa-trash" aria-hidden="true"></i>&nbsp;Slett</button></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>