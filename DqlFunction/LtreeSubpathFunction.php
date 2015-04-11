<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 11.04.15
 * Time: 20:02
 */

namespace Slev\LtreeExtensionBundle\DqlFunction;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class LtreeSubpathFunction extends FunctionNode
{
    protected $first;
    protected $second;
    protected $third;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return $this->third == null ?
            sprintf("subpath(%s, %s)", $this->first->dispatch($sqlWalker), $this->second->dispatch($sqlWalker)) :
            sprintf(
                "subpath(%s, %s, %s)",
                $this->first->dispatch($sqlWalker),
                $this->second->dispatch($sqlWalker),
                $this->third->dispatch($sqlWalker)
            );
    }

    /**
     * @param Parser $parser
     *
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->first = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->second = $parser->ArithmeticPrimary();
        // parse third parameter if available
        if(Lexer::T_COMMA === $parser->getLexer()->lookahead['type']){
            $parser->match(Lexer::T_COMMA);
            $this->third = $parser->ScalarExpression();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}