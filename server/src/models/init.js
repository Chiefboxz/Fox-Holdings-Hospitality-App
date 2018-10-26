const Sequelize = require('sequelize')
const config = require('../config/config')
const fs = require('fs')
const path = require('path')

const db = {}

const sequelize = new Sequelize(
  config.db.name,
  config.db.user,
  config.db.password,
  config.db.options
)

fs
  .readdirSync(__dirname)
  .filter((file) =>
    file !== 'init.js'
  )
  .forEach((file) => {
    const model = sequelize.import(path.join(__dirname, file))
    db[model.name] = model
  })
db[Menu].hasMany(db[Order], {as:'menuID'}),
db[Customer].hasMany(db[Order], {as:'cID'}),
db[Menu].hasMany(db[IngredientsUsed], {as:'menuID'}),
db[Ingredients].hasMany(db[IngredientsUsed], {as:'ingreID'})
  

db.sequelize = sequelize
db.Sequelize = Sequelize

module.exports = db
