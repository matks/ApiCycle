Feature: Movies API
  In order to manage movies
  As an API Client
  I need to be able to use the Movies API

  Scenario: Get basic movies list
    When I fetch movies from the Api
    Then I should receive a list of 3 movies with a total of 30
    And the list should contain:
      | movie name         |
      | Fast and Furious 8 |
      | Taken 3            |

  Scenario: Get advanced movies list
    When I fetch page 3 from movies from the Api using an "desc" sorting on names
    Then I should receive a list of 3 movies with a total of 30
    And the list should contain:
      | movie name            |
      | Another great movie 6 |

  Scenario: Create a movie
    When I create a movie "Amazing new movie Z"
    Then I should receive a success response
    When I fetch page 1 from movies from the Api using an "asc" sorting on names
    Then I should receive a list of 3 movies with a total of 31
    And the list should contain:
      | movie name          |
      | Amazing new movie Z |

  Scenario: Create a movie twice and receive a bad response
    When I create a movie "Spiderman"
    Then I should receive a success response
    When I create a movie "Spiderman"
    Then I should receive a bad response

  Scenario: Delete a movie
    When I delete the movie 31
    Then I should receive a null response
    When I fetch page 1 from movies from the Api using an "asc" sorting on names
    Then I should receive a list of 3 movies with a total of 31
    And the list should NOT contain:
      | movie name          |
      | Amazing new movie Z |

  Scenario: Delete a movie twice and receive a bad response
    When I delete the movie 32
    Then I should receive a null response
    When I delete the movie 32
    Then I should receive a bad response