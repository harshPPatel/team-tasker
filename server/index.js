const express = require('express');
const { GraphQLError } = require('graphql');
const { ApolloServer, ApolloError, ValidationError } = require('apollo-server-express');
const { v4 } = require('uuid');

const db = require('./db');
const verifyToken = require('./api/middlewares/verifyToken');
const typeDefs = require('./api/graphql/schema');
const resolvers = require('./api/graphql/resolvers');
const Token = require('./api/helpers/Token');

require('dotenv').config();

// Creating express app
const app = express();

app.use(express.json());
app.use(verifyToken);

// Root Route
app.get('/', (req, res) => {
  res.json({
    message: 'Welcome to the Team Tasker App\'s API!',
  });
});

// Creating Apollo Server
const server = new ApolloServer({
  typeDefs,
  resolvers,
  formatError: (err) => {
    if (err.originalError instanceof ApolloError) {
      return err;
    }

    // Logging the error
    const errorId = v4();
    console.error(`Error Id: ${errorId}`);
    console.error(err);

    // Returing the GraphQLError
    return new GraphQLError(`Internal Error: ${errorId}`);
  },
  context: ({ req }) => ({
    isValidToken: req.isValidToken,
    error: req.error,
    username: req.username,
  }),
});

// Adding graphql server as middleware to express app
server.applyMiddleware({ app });

// Creating connection to the database
db.getConnection();

// Starting express app
app.listen({ port: 4000 }, () => {
  // eslint-disable-next-line
  console.log(`🚀 Server ready at http://localhost:4000${server.graphqlPath}`)
});
