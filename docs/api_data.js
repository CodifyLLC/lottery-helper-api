define({ "api": [
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/powerball/generateRandomSelectionByMostUsed",
    "title": "generateRandomSelectionByMostUsed",
    "name": "generateRandomSelectionByMostUsed",
    "group": "powerball",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        \"52\",\n        \"28\",\n        \"13\",\n        \"31\",\n        \"41\",\n        \"20\"\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "powerball"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/powerball/generateSelectionByLeastUsed",
    "title": "generateSelectionByLeastUsed",
    "name": "generateSelectionByLeastUsed",
    "group": "powerball",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        \"67\",\n        \"61\",\n        \"62\",\n        \"69\",\n        \"64\",\n        \"26\"\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "powerball"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/powerball/generateSelectionByMostUsed",
    "title": "generateSelectionByMostUsed",
    "name": "generateSelectionByMostUsed",
    "group": "powerball",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        \"12\",\n        \"41\",\n        \"52\",\n        \"28\",\n        \"23\",\n        \"25\"\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "powerball"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/powerball/getUsedNumbers",
    "title": "getUsedNumbers",
    "name": "getUsedNumbers",
    "group": "powerball",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        {\n            \"total\":\"9\",\n            \"number_used\":\"65\"\n        },\n        {\n            \"total\":\"10\",\n            \"number_used\":\"60\"\n        },\n        {\n            \"total\":\"12\",\n            \"number_used\":\"63\"\n        },\n        {\n            \"total\":\"12\",\n            \"number_used\":\"66\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "powerball"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/powerball/getUsedPowerNumbers",
    "title": "getUsedPowerNumbers",
    "name": "getUsedPowerNumbers",
    "group": "powerball",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        {\n            \"total\":\"15\",\n            \"number_used\":\"21\"\n        },\n        {\n            \"total\":\"16\",\n            \"number_used\":\"26\"\n        },\n        {\n            \"total\":\"16\",\n            \"number_used\":\"4\"\n        },\n        {\n            \"total\":\"18\",\n            \"number_used\":\"14\"\n        },\n        {\n            \"total\":\"19\",\n            \"number_used\":\"9\"\n        },\n        {\n            \"total\":\"20\",\n            \"number_used\":\"13\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "powerball"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/winningNumbers/powerballAll",
    "title": "powerballAll",
    "description": "<p>This will get All the powerball winings since 2010</p>",
    "name": "powerballAll",
    "group": "winningNumbers",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":[\n        {\n            \"powerball_id\":\"1\",\n            \"draw_num1\":\"7\",\n            \"draw_num2\":\"9\",\n            \"draw_num3\":\"14\",\n            \"draw_num4\":\"45\",\n            \"draw_num5\":\"49\",\n            \"draw_num6\":\"23\",\n            \"multiplier\":\"4\",\n            \"draw_date\":\"2010-03-03 22:59:00\",\n            \"insert_date\":\"2017-04-06 17:44:33\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "winningNumbers"
  },
  {
    "version": "1.0.0",
    "type": "get",
    "url": "/winningNumbers/powerballCurrent",
    "title": "powerballCurrent",
    "description": "<p>This will get the latest powerball drawing numbers</p>",
    "name": "powerballCurrent",
    "group": "winningNumbers",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of the request. ok or fail</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Generic message about the response</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>More information about the response</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\":\"ok\",\n    \"message\":\"Returned\",\n    \"data\":{\n        \"powerball_id\":\"739\",\n        \"draw_num1\":\"8\",\n        \"draw_num2\":\"15\",\n        \"draw_num3\":\"31\",\n        \"draw_num4\":\"36\",\n        \"draw_num5\":\"62\",\n        \"draw_num6\":\"11\",\n        \"multiplier\":\"3\",\n        \"draw_date\":\"2017-03-29 00:00:00\",\n        \"insert_date\":\"2017-04-06 17:47:33\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "winningNumbers"
  }
] });
