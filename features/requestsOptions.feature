Feature: Mock server request options
  Scenario: Receiving a valid response when asking for a GET request mock
    Given I prepare a "GET" request on "/test"
    When i send the request
    Then the response should contain the following JSON
    """
    {
        "plop": {
            "plip": 13,
            "foo": "bar"
        }
    }
    """
    Then the status code should be 200
    Then the request should take a delay of 5
