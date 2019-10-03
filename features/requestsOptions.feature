Feature: Mock server request options
  Scenario: Receiving a valid response when asking for a GET request with a delay
    Given I prepare a "GET" request on "/get404"
    When i send the request
    Then the response should contain the following JSON
    """
    { "data": [ {"test" : 123456789, "test2" : 123456789 } ]}
    """
    Then the status code should be 404
    Then the request should take a delay of at least 2
  Scenario: Receiving a valid response when asking for a POST request with no delay
    Given I prepare a "POST" request on "/post200"
    When i send the request
    Then the response should contain the following JSON
    """
    { "logged": true}
    """
    Then the status code should be 200
    Then the request should take a delay of at least 0
  Scenario: Receiving a 5 response when asking for a GET request with no delay
    Given I prepare a "PUT" request on "/error500"
    When i send the request
    Then the response should contain the following JSON
    """
    { "errors": [ {"code" : 1234, "message" : "Internal server error" } ]}
    """
    Then the status code should be 500
    Then the request should take a delay of at least 0
