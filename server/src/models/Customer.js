const bcrypt = require('bcrypt')

module.exports = (sequelize, DataTypes) => {
  const Customer = sequelize.define('Customer', {
    cID: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true
    },
    cFirstname: {
      type: DataTypes.STRING
    },
    cLastname: {
      type: DataTypes.STRING
    },
    cNumber: {
      type: DataTypes.INTEGER,
      unique: true
    },
    cEmail: {
      type: DataTypes.STRING,
      unique: true
    },
    cPassword: {
      type: DataTypes.STRING
    }
  })

  Customer.prototype.comparePassword = (password) => {
    return bcrypt.compare(password, this.cPassword)
    // return password === this.password
  }

  return Customer
}
