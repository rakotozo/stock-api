# Sql utils


UPDATE product_supplier ps
SET quantity = COALESCE((
    SELECT SUM(CASE WHEN sm.type = 'IN' THEN sm.quantity ELSE -sm.quantity END)
    FROM stock_movement sm
    WHERE sm.product_supplier_id = ps.id
), 0);


