<?php

namespace App\Http\Controllers\GamePackAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\gamePreference;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;

use function GuzzleHttp\json_decode;
use function PHPSTORM_META\map;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQuestions(Request $request)
    {
        $questionsFilter = $request->input('filterType');
        $gamePreferenceCode = $request->input('gamePreferenceCode');
        $topicID = $request->input('topicID');
        $questionsLimit = $request->input('questionsCount');;
        
        // Load Questions
        $questions = [];
        if ( $questionsFilter == "GamePreference" ) 
        {
            $gamePreference = gamePreference::where('code' , $gamePreferenceCode)->first();

            if ( $gamePreference->count() == 0 )
                return $this->renderReponse(false, 'Game Preference Code Is Not Exist' , []);
            $exercisesets = $gamePreference->exercisesets();
            foreach ($exercisesets as $index => $exerciseset)
               foreach ($exerciseset->questions as $question)
                   $questions[] = $question;
        }
        else if ( $questionsFilter = "Topic" )
        {
            $topic = Topic::find($topicID);
            $exercisesets = $topic->exercisesets;
            foreach ($exercisesets as $index => $exerciseset)
               foreach ($exerciseset->questions as $question)
                   $questions[] = $question;
        }
        
        // shuffling questions 
        shuffle($questions);

        // questions count limitation
        $questions = array_slice($questions,0,$questionsLimit);

        // Rendering Questions
        $renderedQuestions = $this->renderQuestions($questions);
        return $this->renderReponse(true, null , $renderedQuestions);
    }

    public function renderReponse( $succeed , $error , $questions  ){
        $response = [
            'succeed' => $succeed,
            'error' => $error, 
            'questions' => $questions
        ];
        return new JsonResponse($response);
    }

    public function renderQuestions($questions)
    {
        $renderedQuestions = [];
        foreach ($questions as $question) {

            $json_details = json_decode($question->json_details);

            # template
            $renderedQuestion = [
                'id' => 0,
                'attributes' => [],
                'sections' => [],
                'answers' => [],
            ];

            $question_data = $json_details->Questions[0];
            
            $renderedQuestion['id'] = $question->id;


            // Question Attributes
            $renderedQuestion['attributes']['minTime'] = $question_data->Attributes->MinTime;
            $renderedQuestion['attributes']['maxTime'] = $question_data->Attributes->MaxTime;
            $renderedQuestion['attributes']['difficulty'] = $question_data->Attributes->Difficulty;

            // Question Sections
            $sections = $json_details->Questions[0]->Question_Description->Sections;
            foreach ($sections as $index => $section) {
                $renderedQuestion['sections'][$index]['type'] = $section->SectionType;
                $renderedQuestion['sections'][$index]['value'] = $section->Value;
            }

            // Question Answers
            # template
            $answers = [
                0 => [
                    'id' => 0,
                    'isCorrect' => false,
                    'value' => null
                ]
            ];
            $answers = []; // reset


            $choices = $question_data->Answers->Choices;

            foreach ($choices as $index => $choice) {
                $answers[$index]['id'] = $choice->Attributes->id;
                $answers[$index]['isCorrect'] = $choice->Attributes->IsCorrect;
                $answers[$index]['value'] = $choice->Sections[0]->Value;
            }
            shuffle($answers);
            $renderedQuestion['answers'] = $answers;

            $renderedQuestions[] = $renderedQuestion;
        }

        return $renderedQuestions;
    }

}
