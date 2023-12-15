Feature:
    In order to verify the logic behind my algorithms for day 15 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day15/1/day15test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "1320"

    Scenario: Check part2
        When I request "/day15/2/day15test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""
