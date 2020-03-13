require('dotenv').config();

const express = require('express');
const { GraphQLError } = require('graphql');
const { ApolloServer, ApolloError } = require('apollo-server-express');
const { v4 } = require('uuid');

const db = require('./db');
const verifyToken = require('./api/middlewares/verifyToken');
const typeDefs = require('./api/graphql/schema');
const resolvers = require('./api/graphql/resolvers');

const PORT = process.env.PORT || 5000;

// Creating express app
const app = express();

app.use(express.json());

// Root Route
app.get('/', (req, res) => {
  res.json({
    message: 'Welcome to the Team Tasker App\'s API!',
  });
});

app.use(verifyToken);

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
    console.error(err.extensions.exception.stacktrace);

    // Returing the GraphQLError
    return new GraphQLError(`Internal Error: ${errorId}`);
  },
  context: ({ req }) => ({
    isValidToken: req.isValidToken,
    error: req.error,
    username: req.username,
    token: req.token,
    user: req.user,
  }),
});

// Adding graphql server as middleware to express app
server.applyMiddleware({ app });

// Creating connection to the database
db.getConnection();

// Starting express app
app.listen({ port: PORT }, () => {
  // eslint-disable-next-line
  console.log(`🚀 Server ready at http://localhost:${PORT}${server.graphqlPath}`)
});
