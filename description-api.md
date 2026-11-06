
# Démarage du serveur test: ou de dev : 

php -S localhost:8000 -t public


*************************************************************************************
# Création d'une catégorie
POST : http://localhost:8000/api/categories

`
    Header : 
        Content-Type : application/ld+json
        Accept : application/ld+json
`

`
    {
        "name":"dddd",
        "description":"desc"
    }
`

`
    {
    "@context": "/api/contexts/Category",
    "@id": "/api/categories/2",
    "@type": "Category",
    "id": 2,
    "name": "test",
    "description": "desc",
    "createdAt": "2026-11-06T07:16:50+01:00"
    }
`

*************************************************************************************
# Création d'un Prouit
POST: http://localhost:8000/api/products

`
    Header : 
        Content-Type : application/ld+json
        Accept : application/ld+json
`

`
    {
        "name": "Produit 1",
        "reference": "12054",
        "description": "description",
        "purchasePrice": "200",
        "sellingPrice": "200",
        "minStock": 1,
        "category": "/api/categories/2"
    }
`
`
    {
        "@context": "/api/contexts/Product",
        "@id": "/api/products/1",
        "@type": "Product",
        "id": 1,
        "name": "Produit 1",
        "reference": "12054",
        "description": "description",
        "purchasePrice": "200.00",
        "sellingPrice": "200.00",
        "minStock": 1,
        "createdAt": "2026-11-06T07:31:06+01:00",
        "category": "/api/categories/2"
    }
`

*************************************************************************************
# Création d'un Fournisseur
POST : http://localhost:8000/api/suppliers

`
    Header : 
        Content-Type : application/ld+json
        Accept : application/ld+json
`

`
    {
    "name": "YMP",
    "email": "ympg@gmail.com",
    "phone": "034 50 588 43",
    "address": "YMP"
    }
`

## Response
`
    {
    "@context": "/api/contexts/Supplier",
    "@id": "/api/suppliers/2",
    "@type": "Supplier",
    "id": 2,
    "name": "YMP",
    "email": "ympg@gmail.com",
    "phone": "034 50 588 43",
    "address": "YMP",
    "createdAt": "2026-11-06T12:04:43+01:00"
    }
`


*************************************************************************************


# Création d'un pruidt avec un fournisseur

POST : http://localhost:8000/api/product_suppliers

`
    Header : 
        Content-Type : application/ld+json
        Accept : application/ld+json
`

`
    {
    "product": "/api/products/1",
    "supplier": "/api/suppliers/2",
    "quantity" : 12,
    "purchasePrice": "2030.2",
    "sellingPrice" : "25000"
    }
`
## Response
`
    {
    "@context": "/api/contexts/ProductSupplier",
    "@id": "/api/product_suppliers/4",
    "@type": "ProductSupplier",
    "id": 4,
    "product": "/api/products/1",
    "supplier": "/api/suppliers/2",
    "quantity": 12,
    "purchasePrice": "2030.20",
    "sellingPrice": "25000.00",
    "createdAt": "2026-11-06T12:04:59+01:00",
    "margin": "-1830.20"
    }
`

*************************************************************************************
# Création d'un mouvement de stock, stock détail

POST : http://localhost:8000/api/stock_movements

`
    Header : 
        Content-Type : application/ld+json
        Accept : application/ld+json
`

`
    {
        "quantity": 5,
        "unitPrice": "20000",
        "reason": "string",
        "productSupplier": "/api/product_suppliers/2",
        "type": "IN"
    }
`

`
    {
        "@context": "/api/contexts/StockMovement",
        "@id": "/api/stock_movements/1",
        "@type": "StockMovement",
        "id": 1,
        "quantity": 5,
        "unitPrice": "20000.00",
        "reason": "string",
        "createdAt": "2026-11-06T12:52:31+01:00",
        "productSupplier": "/api/product_suppliers/2",
        "type": "IN"
    }
`
## Nouvelle entré en stock de 30 produits
`
{
  "quantity": 30,
  "unitPrice": "20000",
  "reason": "Entré en stock",
  "productSupplier": "/api/product_suppliers/2",
  "type": "IN"
}

`
