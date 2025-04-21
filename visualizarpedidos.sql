-- Visualizar todas as informações dos pedidos
select *
from users,pedido,pedidoitem,item
where users.cod = pedido.usercod and pedidoitem.idpedido = pedido.id and pedidoitem.iditem = item.id;